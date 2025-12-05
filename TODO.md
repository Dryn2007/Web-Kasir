# TODO List for Separating Welcome Navbar and Adding Text to Dashboard Navbars

-   [x] Modify resources/views/layouts/navigation.blade.php to add app name text on the left.
-   [x] Create resources/views/layouts/navigation-welcome.blade.php, based on navigation.blade.php but with "Welcome" text on the left instead of nav links.
-   [x] Create resources/views/layouts/welcome.blade.php, similar to app.blade.php but including 'layouts.navigation-welcome'.
-   [x] Change resources/views/welcome.blade.php to use @extends('layouts.welcome') instead of <x-app-layout>.
