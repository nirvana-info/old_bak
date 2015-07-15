# ActionMailer::Base.delivery_method = :smtp
ActionMailer::Base.delivery_method = :sendmail

ActionMailer::Base.smtp_settings = {
    :address              => "smtp.gmail.com",
    :port                 => 587,
    :domain               => "gmail.com",
    :user_name            => "vangogh.nirvana",
    :password             => "ni@123456",
    :authentication       => "plain",
    :enable_starttls_auto => true
  }

ActionMailer::Base.sendmail_settings = {
    :location  => '/usr/sbin/sendmail',
    :arguments => '-t'   # for postfix, add -i for sendmail
  }