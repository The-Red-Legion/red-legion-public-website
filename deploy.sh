#!/bin/bash
set -e

echo "=== Red Legion Website Deployment ==="
echo "Starting lightweight deployment for f1-micro VM..."

# Check system resources
echo "Current system status:"
free -h
df -h /

# Clean up first
echo "Cleaning package cache..."
sudo apt-get clean
sudo apt-get autoremove -y --quiet

# Update package list
echo "Updating package list..."
sudo apt-get update -qq

# Install packages one by one to avoid overwhelming the system
echo "Installing Nginx..."
sudo apt-get install -y nginx

echo "Installing MySQL..."
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server

echo "Installing PHP 8.1..."
sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update -qq
sudo apt-get install -y php8.1 php8.1-fpm php8.1-mysql php8.1-curl php8.1-gd php8.1-xml php8.1-mbstring php8.1-zip

echo "Installing Composer..."
sudo apt-get install -y composer

# Start services
echo "Starting services..."
sudo systemctl enable nginx
sudo systemctl start nginx
sudo systemctl enable php8.1-fpm
sudo systemctl start php8.1-fpm
sudo systemctl enable mysql
sudo systemctl start mysql

# Create application directory
echo "Setting up application..."
sudo mkdir -p /opt/red-legion-website
sudo chown www-data:www-data /opt/red-legion-website

# Basic Nginx configuration
echo "Configuring Nginx..."
sudo tee /etc/nginx/sites-available/red-legion > /dev/null << 'EOF'
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    server_name dev.redlegion.gg;
    root /opt/red-legion-website/public_html;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
EOF

# Enable site
sudo rm -f /etc/nginx/sites-enabled/default
sudo ln -sf /etc/nginx/sites-available/red-legion /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Set up basic database
echo "Setting up database..."
sudo mysql -e "CREATE DATABASE IF NOT EXISTS red_legion_website;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'website_user'@'localhost' IDENTIFIED BY 'temp_password_to_be_changed';"
sudo mysql -e "GRANT ALL PRIVILEGES ON red_legion_website.* TO 'website_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# Create a simple index.php for testing
echo "Creating test page..."
sudo mkdir -p /opt/red-legion-website/public_html
sudo tee /opt/red-legion-website/public_html/index.php > /dev/null << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>Red Legion Website</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
        .logo { font-size: 48px; color: #d32f2f; font-weight: bold; }
        .subtitle { font-size: 18px; color: #666; margin-top: 20px; }
        .status { margin-top: 40px; padding: 20px; background: #f5f5f5; border-radius: 10px; display: inline-block; }
    </style>
</head>
<body>
    <div class="logo">THE RED LEGION</div>
    <div class="subtitle">Star Citizen Organization</div>
    <div class="status">
        <h3>Deployment Status: ✅ SUCCESS</h3>
        <p>PHP Version: <?php echo phpversion(); ?></p>
        <p>Server Time: <?php echo date('Y-m-d H:i:s'); ?></p>
        <p>Database: <?php
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=red_legion_website', 'website_user', 'temp_password_to_be_changed');
                echo "✅ Connected";
            } catch(PDOException $e) {
                echo "❌ Connection failed";
            }
        ?></p>
    </div>
</body>
</html>
EOF

sudo chown -R www-data:www-data /opt/red-legion-website

echo "=== Deployment Complete ==="
echo "Services status:"
sudo systemctl is-active nginx
sudo systemctl is-active php8.1-fpm
sudo systemctl is-active mysql

echo ""
echo "Testing website..."
curl -s http://localhost/ | grep "Red Legion" && echo "✅ Website is responding!" || echo "❌ Website not responding"

echo ""
echo "🎉 Red Legion Website deployed successfully!"
echo "Visit: http://dev.redlegion.gg/"