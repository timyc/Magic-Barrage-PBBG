I will no longer be working on this (most likely), and as incomplete as it is, I felt that this would have been wasted sitting as a private repo

Key features:
- Guest players
- Server-side auto attacks (gain EXP/loot while offline!)
- Websocket based rather than HTTP polling
- Multi class/starting location

How to install:
PHP 8.2, MySQL > 8 or MariaDB > 10.6, NodeJS 18, any modern version of Redis will work. Linux is a must since you will need PHP's pcntl.

Install soketi by running `npm install -g @soketi/soketi` and `cp soketi.json.example soketi.json` and run configure the values as you like and run `soketi start --config=soketi.json`
Grab your invisible reCAPTCHA v2 key too while you're at it since you'll need to put it in your `.env`

Now after you've done your `composer update` you'll want to install Laravel Horizon `php artisan horizon:install` and run it using `php artisan horizon`

Once again, I've nuked the development database containing pre-configured values unfortunately. 
You're going to need to create a `MOTD` row in the `server_settings` table and create a couple of starter locations ID'd 1-4 and a coupon mobs for those locations too. If you accidentally already entered the game, just do a quick `php artisan cache:clear` and it should be good

We'll now be at the home screen
![Screenshot_408](https://github.com/timyc/Magic-Barrage-PBBG/assets/29265905/c57653e5-534c-4964-b1a8-1f9ac7cafb55)

If you're a spammer with a negative social credit IP address, you'll see this when you try to get in as a guest
![Screenshot_409](https://github.com/timyc/Magic-Barrage-PBBG/assets/29265905/df68cfde-9a25-479e-b6b4-d4f60ddf056d)

Complete the captcha and you'll be greeted with the character screen
![Screenshot_410](https://github.com/timyc/Magic-Barrage-PBBG/assets/29265905/fcb62c94-4707-41af-ad05-4471917302a5)

Go create a character
![Screenshot_411](https://github.com/timyc/Magic-Barrage-PBBG/assets/29265905/14c9eb78-2989-455d-a448-87a478a57519)

and select a mode
![Screenshot_412](https://github.com/timyc/Magic-Barrage-PBBG/assets/29265905/98fb1636-632d-40d3-8358-e31fc3256ab5)

and you're off to the races
![Screenshot_413](https://github.com/timyc/Magic-Barrage-PBBG/assets/29265905/4cfb7bf3-a0c9-4ba7-b680-e14bc03834ac)

Very feature in-complete but hey, your game is already better than Lyrania.
