Holoshop
====

# Odd stuff happening?

## `Call to undefined function Termwind\ValueObjects\mb_strimwidth()`
Install php extension `mbstring`

Debian/Ubuntu
```bash
sudo apt-get install php8.1-mbstring
```
MacOS
```bash
sudo brew install php80-mbstring
```
Windows - lol save yourself. My condolences 🙏

# Known issues

- `/admin/logs/login` pushes the sidebar all the way to the side




# Development Standards

## Privilege Namings
All name (keys) for privileges stored in the database should follow the following format
 
| type               | format                 | examples                            |
|--------------------|------------------------|-------------------------------------|
| Access to resource | `LOCATIONS_RESOURCE`   | `DASHBOARD_ROLES` `FORUM_SUPPORT`   |
| Action on resource | `RESOURCE_EDIT(_PART)` | `ROLES_EDIT_DESC` `PRIVILEGES_EDIT` |
| Negation           | `NOT_KEY`              | `NOT_GLOBAL_SITE` (bans member)     |

Value for staff privileges start at `1 << 1`, others should start at `1 << 25`.
This does give us only 25 staff keys, but that should be enough for now.
The system will auto generate some keys with `1 << 32` and above for locking forums; etc





