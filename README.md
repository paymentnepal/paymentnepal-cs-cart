# paymentnepal-cs-cart
To install plugin copy all files to your site root catalogue.

Next install plugin in administrator apnel in "Plugins -> Plugin management -> All available plugins" select plugin "Paymentnepal payment method" and click "Install"

Add payment method: "Administration -> Payment methods" choose "Paymentnepal" processor, when "Settings" tab appears fill in secret key and payment key (can be obtained in service settings inside your Paymentnepal merchant area)

Inside service settings fill in:

Notification URL:
your_domain/index.php?dispatch=payment_notification.result&payment=paymentnepal

Success URL:
your_domian/index.php?dispatch=payment_notification.return&payment=paymentnepal

Fail URL:
your_domain/index.php?dispatch=payment_notification.cancel&payment=paymentnepal

Plugin was tested on version 4.2.2
