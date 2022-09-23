# Online Booking Custom Views
Completely customize your ClinicSoftware.com Online Booking's look and feel with full native access to the views.


# Instructions

### Requirements
- PHP 7.4+
- Very basic PHP knowledge
- Basic computer knowledge

<br>

### Examples
The [Examples Folder](./examples/) will contain a list of available examples that have been created, you can use any of these as a starting point if you feel like any of them will fit your desired look/feel.

Please keep in mind that all these examples have been crafted exactly for this purpose, as examples.

### Variables
To simualte the `PHP` variables, received from your license, these can be found in the [Environment Variables File](./env.php)

### Getting Started
To get started with the custom views you can simply open up one of the many [Examples Folder](./examples/) or start off from the [Base](./base) which contains all of the features with none removed, the look and feel it's exactly the same as in ClinicSoftware.com's online booking.

### How to run
To run the project please run the [run.sh](./run.sh) file if on Linux or MacOS, for windows you might have to just run `php -S 0.0.0.0:8000 -t base/` manually but have a look in the [run.sh](./run.sh) file to make sure, you **MUST** make sure that you have `PHP 7.4` installed in the global PATH variable.


# Page Descriptions

### [settings.php](./base/settings.php)
This file isn't actually won't be used in ClinicSoftware, but it's a means to load in the settings and simulate the Software's behaviour to some extent

### [index.php](./base/index.php)
This is the booking landing page/first step which lists your service sections in the online booking page.

### [booking_progress_step1.php](./base/booking_progress_step1.php)
The steps at the top of the page, this is for the first page [index.php](./base/index.php)
