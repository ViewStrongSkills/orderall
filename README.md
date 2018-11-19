# Stuff to do before app can be launched

## Very Important

- Fix times bug (?)

## Not very important

- Get notifications working

Permissions:

| Function | Not logged in | User | Business | Admin |
|----------|---------------|------|----------|-------|
| View business | Yes | Yes | Yes | Yes |
| View main/contact/help/partner/tos/privacy | Yes | Yes | Yes | Yes |
| Search for users| No           | No   | No       | Yes   |
| Change user permissions | No | No | No | Yes |
| Add/remove cart item | No    | Yes  | Yes      | Yes   |
| Complete order | No | Yes | Yes | Yes |
| Verify account | No | Yes | No | No |
| Create new menu item / extra | No | No | Yes (only own business) | Yes |
| Edit menu item / extra | No | No | Yes (only own business) | Yes |
| Delete menu extra / item | No | No | Yes (only own business) | Yes |
| Create new business | No | No | Yes (only when there is no business associated) | Yes |
| Delete business | No | No | Yes (only own business) | Yes |
| View all user transactions | No | Yes (only own transactions) | Yes (only own transactions) | Yes |
| View all business transactions | No | No | Yes (only for own business) | Yes |
| View single user transaction | No | Yes (only for own transaction) | Yes (only for own transaction) | Yes |
| View single business transaction | No | No | Yes (only own business) | Yes |
| Update user information | No | Yes | Yes | Yes |
| Search businesses by name | Yes | Yes | Yes | Yes |
| Search businesses by tag | Yes | Yes | Yes | Yes |
| Write review for items that have been ordered | No | Yes | Yes | Yes |

An unverified user shouldn't be able to do anything a verified user should, except for verify their account.
A developer should be able to do everything.

## CSS/Bootstrap/Etc.

Add the following lines to your .env file:

GOOGLE_API_KEY = AIzaSyC0MjT78xD0O5hXUPiZWUS4WL_rJuYIcss

TWILIO_AUTH_TOKEN=9ddde882c7a7f939fb47bf810b22f9a4

TWILIO_ACCOUNT_SID=AC8dd672c526ea87afb12e155d68ebabab

The four test accounts are developer, admin, user and business. Their usernames are the name + @foo.com, for example developer@foo.com, and the passwords are all 123123.

# Things to do on launch

- Comment out all the things that need commenting
