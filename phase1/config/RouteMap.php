<?hh

namespace Config;

class RouteMap {

// Defines the routing mapping from the request URI to the controller.
public static Map<string, string> $s_map = Map {
  "/account" => "AccountController",
  "/activate_account" => "ActivateAccountController",
  "/example" => "ExampleController",
  "/error" => "ErrorController",
  "/home" => "HomePageController",
  "/login" => "LoginController",
  "/logout" => "LogoutController",
  "/register_user" => "RegisterUserController",
  "/user_settings" => "UserSettingsController",
  "/venues" => "VenueController",
};

}
