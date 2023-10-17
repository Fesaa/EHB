Holoshop
====

# TODO's
Stuff that I've put off to work on other functionality
- Creating new roles from the admin panel
- Punish users & list punishments
- Add featured switch on threads edit
- Add change date on threads (for ordering featured page)
- Make forums have a weight for ordering on the forums page
- Delete forums, threads, posts, profile posts, etc
- Contact page

# Known issues
These are issues that I found while playing around, and hadn't have time to fix them then

- `/admin/logs/login` pushes the sidebar all the way to the side
- ~~`ROLES_EDIT_MISC` does not give you access to the edit button~~
- ~~`/admin/logs` loads extremely slow- find new image~~
- `/admin/logs/*` filter isn't hold into place correctly
- `/forum/*` description overflows if it has no spaces
- The post editor makes the posts bigger

# Extra TODO's
These are TODO's I originally wasn't going to implement, and aren't needed. But would be fun!
- Users with the `FORUMS_CREATE` privilege should get a message on the forums page to create a forum if none are present
- Re-order ccs files
- Check for XSS & client-side validation

# Development Standards
These are some standards I tried to follow, or will follow/implement in my project to keep it orderly for me.

## Empty getters
A getter that might return something indicating an absence should be named `get<Name>`, one that never returns null should be named `<Name>`.
I.e. `Forum#getVisibleForums` but `User#profile`

## Imports
**Always** use imports instead of complete name spaces. In `.blade.php` files make a `@php` block at the top of the file and import there. The long stuff is just plain ugly.

## Privilege Namings
All name (keys) for privileges stored in the database should follow the following format
 
| type               | format                 | examples                            |
|--------------------|------------------------|-------------------------------------|
| Access to resource | `LOCATIONS_RESOURCE`   | `DASHBOARD_ROLES` `FORUM_SUPPORT`   |
| Action on resource | `RESOURCE_EDIT(_PART)` | `ROLES_EDIT_MISC` `PRIVILEGES_EDIT` |
| Negation           | `NOT_KEY`              | `NOT_GLOBAL_SITE` (bans member)     |

Value for staff privileges start at `1 << 1`, others should start at `1 << 25`.
This does give us only 25 staff keys, but that should be enough for now.
The system will auto generate some keys with `1 << 32` and above for locking forums; etc


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



