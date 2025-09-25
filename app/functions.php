<?php
/* Functions
 * This file contains various functions used throughout the application.
 * @author : Tealstone
 */

// d() 
//
// Show debug information only to people in the $_DEBUG_USERS array.
// Accepts any type of variable, including arrays and objects.
// Recursively converts objects to arrays for easier viewing.
function d($display)
{

        if(true)
        {
                echo '<br><font color="red">**START**</font> <pre>';

                if(is_array($display))
                {
                        print_r($display);
                }
                elseif(is_object($display))
                {
                        $d = @get_object_vars($display);
                        if(is_array($d))
                        {
                                /*
                                 * Return array converted to object Using __FUNCTION__ (Magic constant)
                                 * for recursive call.
                                 */
                                print_r(array_map(__FUNCTION__, $d));
                        }
                        else
                        {
                                print_r($d);
                        }
                }
                elseif (is_bool($display))
                {
                     if ($display)
                     {
                         echo 'Boolean: true';
                     }
                     else
                     {
                         echo 'Boolean: false';
                     }
                }
                elseif (is_null($display))
                {
                    echo 'NULL';
                }
                else
                {
                        echo $display;
                }

                echo '</pre><font color="red">**END**</font>';
        }
}

# A function to redirect user.
function redirect($url)
{
    if (!headers_sent())
    {
        header('Location: '.$url);
        exit;
        }
    else
        {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
    }
}

function getApplyURI()
{
        //Set the redirect URL based on environment.
        switch($_ENV['APP_ENV'])
        {
        case 'prod':
                $redirect_url = $_ENV['DISCORD_APPLY_REDIRECT_PROD'];
                break;
        case 'dev':
                $redirect_url = $_ENV['DISCORD_APPLY_REDIRECT_DEV'];
                break;
        case 'local':
                $redirect_url = $_ENV['DISCORD_APPLY_REDIRECT_LOCAL'];
                break;
        default:
                die('Invalid APP_ENV value. Must be one of: local, dev, prod.');
        }

        return $redirect_url;
}