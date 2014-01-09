<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --- Facebook Ignited ---
 *
 * fb_appid   is the app id you recieved from dev panel
 * fb_pageid  if the app has a Facebook Page this will make sure you can interact.
 * fb_secret  is the secret you recieved from dev panel
 * fb_canvas  the value you put in 'Canvas Page' field in dev panel or the address of your app.
 *            See example below the config.
 * fb_apptype set to either 'iframe' or 'connect' based on what platform your app is
 *            is running on.
 * fb_auth    is the default authentications, '' is basic authentication
 * fb_upload  tells the SDK whether or not file uploads are enabled on your server.
 */
$config['appid']     = '651377341552809';

$config['fb_secret']    = '373354005a6babe5b609cb10995c0075';






/**
 * --- fb_canvas examples ---
 * iframe     your-facebook-namespace
 * connect    www.your-connect-domain.com/subfolder/
 */