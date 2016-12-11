# WPAPI-SwaggerGenerator
Generate a swagger file for your Wordpress, based on the plugins installed.

Download the zip file and install using the plugins install upload.

Go to http://yourwordpresssite.example.com/index.php/wp-json/apigenerate/swagger to get 
the swagger file in JSON format. At this stage this plugin does not generate yaml files.

This plugin works well with WP-APIv2 and any plugin that uses the WP_REST_Server
class to register it's API's

This plugin will detect the WP API Oauth1.0a plugin and add that to the "securityDefinitions". Note that Swagger does not support authenticating by Oauth1 and I have added this in the definition produced.

## Troubleshooting
Your REST-API endpoint should define a `schema` array entry (else how would we generate the swagger docs).

[Registering the schema](https://github.com/starfishmod/WPAPI-SwaggerGenerator/blob/master/lib/class-wp-rest-swagger-controller.php#L28)

**Defining the schema**
 * One way of doing [WooCommerce](https://github.com/woocommerce/woocommerce/blob/master/includes/api/class-wc-rest-customer-downloads-controller.php#L153)
 * Another [This Plugin](https://github.com/starfishmod/WPAPI-SwaggerGenerator/blob/master/lib/class-wp-rest-swagger-controller.php#L310)
