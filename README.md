# WIP TicketService

## How it works?

Ticket service allows you to store and manage "Contact Us", "Complain" and other get in touch forms you 
have in your app. The service provides a single api method which creates a new ticket from your clients.
You can access all the tickets by an admin dashboard, assign them to your agents and watch for statuses.
Create any category like "Contact Us", "Complain", "Refund Request" and filter them for easy access.


## Info

[PHP8.2](https://www.php.net/releases/8.2/en.php) |
[Symfony 6](https://symfony.com) |
[EasyAdminBundle](https://symfony.com/bundles/EasyAdminBundle/current/index.html)

### Installation

```bash
make install
make migrate
```

### Create a user

```bash
make ssh
php bin/console app:create-user
```

### Tests

```bash
make test
```

License
-------

This software is published under the [MIT License](LICENSE.md)

[1]: https://github.com/amvid/geo-service/tree/main/LICENSE.md
