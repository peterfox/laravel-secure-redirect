# Laravel Secure Redirect Back

The purpose of this repo is to highlight how you can protect against abuse
of the `Referer` HTTP header.

# The Exploit

The exploit itself is fairly simple in that the `Referer` header of an HTTP Request can be written
to be a different domain, causing the application code to use this as the URL to redirect
to when the `back()` method is called using the `Redirector` class commonly used via the
`redirect()` helper.

The exploit helps those performing phishing style attacks where the user is on the legitimate
domain and then submits a form with invalid validation and then sends the user to a different website
which looks the same as the original, allowing the attacker to trick a user into potentially handing over
account login details for the original site or other information.

This has been documented before https://github.com/laravel/framework/issues/14642

# The Fix

To resolve this problem, there should be a quick URL check to make sure the URL is either the App URL
(`app.url` in the config) or is in a list of whitelisted domains. In this demo it's just the
App URL.

The code to change this involves overriding the `Redirector` class so the `back()` method is resolved
and that the `App/Exceptions/Handler` class overrides the `invalid()` method so that it will
avoid using the previous url as per the `UrlGenerator` class.

# Tests

Tests are provided to show the two scenarios working to block the altered `Referer` header.
