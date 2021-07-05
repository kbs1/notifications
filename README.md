Notifications microservice
===========
A small microservice written in Laravel allowing multiple clients to send notifications through supported services.

Definitions
===========
- *Client* - remote caller (consumer) of the API.
- *API key* - unique key used to identify the caller in each request
- *Service* - notification sending service, each Client can configure multiple services
- *Template* - notification template, containing title and body
- *Attachment* - attachable file
- *Notification* - sent notification, after applying any replacements and attaching arbitrary number of attachments

Operation
===========
Since every implemented Service type requires different configuration and notification recipient details,
they operate independently by inheriting from the `App\Services\Handler` base class and implementing
`serviceValidationRules`, `notificationValidationRules` and `sendNotification` methods.

Notification sending process
===========
Notifications are independent of each other, so they can be sent in parallel by utilising a chosen number of
queue workers.

Webhook callbacks
===========
It is possible to include a success / failure webhook callback for every sent notification.

Notifications rentention
===========
Old sent notifications are deleted after `notifications_retention_days` passed (can be defined for each Client).

TODO
===========
Tests, documentation, more service implementations, reusable client class offering a fluent interface to the API.

Quick look
===========
The project comes with a very crude web UI allowing the developer to quickly sync attachments, services, templates
and send messages. The UI is very limited in it's capabilities, the full potential of the API can be utilised by
calling it programatically using JSON payloads instead of web forms.
