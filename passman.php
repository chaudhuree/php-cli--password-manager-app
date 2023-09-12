<?php

// admin credentials

$admin = [
  'username' => 'chaudhuree',
  'password' => 'secret'
];

// welcome message for the first time
// when the user change the password then this message will not be shown
function defaultMessage($admin)
{
  if ($admin['username'] == 'chaudhuree' & $admin['password'] == 'secret') {
    echo "-------------------------------------------------------------\n";
    echo "your default username is chaudhuree and password is secret\n";
    echo "please change your password to secure your software..\n";
    echo "-------------------------------------------------------------\n";
  };
};

//  change admin password function
function changeAdminPassword(&$admin, $oldpassword, $newusername, $newpassword)
{
  if ($admin['password'] == $oldpassword) {
    $admin['username'] = $newusername;
    $admin['password'] = $newpassword;
    echo "Password changed successfully\n";
  } else {
    echo "Old password is incorrect\n";
    echo "Please try again\n";
  }
}

// Password storage (insecure, replace with secure storage)
$passwords = [
  "gmail.com" => ["email" => "chaudhuree@gmail.com", "password" => "itssecret"],
];

// Functions to add and retrieve passwords
function addPassword(&$passwords, $website, $email, $password)
{
  $passwords[$website] = ["email" => $email, "password" => $password];
  echo "Credentials added for $website\n";
}


function getPassword($passwords, $website)
{
  if (isset($passwords[$website])) {
    return $passwords[$website];
  } else {
    echo "Credentials not found for $website\n";
    return null;
  }
}

echo "Welcome to the Password Manager CLI\n";
defaultMessage($admin);

// colorize terminal echo
function colorize($text, $colorCode)
{
  
  $colors = [
    'red' => "\033[31m",
    'green' => "\033[32m",
    'yellow' => "\033[33m",
    'blue' => "\033[34m",
    'reset' => "\033[0m" 
  ];

  if (array_key_exists($colorCode, $colors)) {
    return $colors[$colorCode] . $text . $colors['reset'];
  } else {
    return $text; // Use the default color if the specified color is not found
  }
}
// Login function
function login($admin)
{
  echo "
_           ___        ____      ____      ____  
| |         /   \      /    |    |    |    |    \ 
| |        |     |    |   __|     |  |     |  _  |
| |___     |  O  |    |  |  |     |  |     |  |  |
|     |    |     |    |  |_ |     |  |     |  |  |
|     |    |     |    |     |     |  |     |  |  |
|_____|     \___/     |___,_|    |____|    |__|__|
                                                 
                                                       
\n";

  echo "Please authenticate yourself to continue.\n";
  // Authenticate the user
  $authenticated = false;
  for ($i = 0; $i < 3; $i++) { // Allow three attempts
    $inputUsername = readline("Username: ");
    $inputPassword = readline("Password: ");

    if ($inputUsername === $admin['username'] && $inputPassword === $admin['password']) {
      $authenticated = true;
      break;
    } else {
      echo "Authentication failed. Please try again.\n";
    }
  }

  if (!$authenticated) {
    echo "Authentication failed. Exiting...\n";
    exit(1);
  }

  echo "Authentication successful!\n";
  echo "
____      __ __      ______      __ __       ___       ____       ____      _____        ___      ___   
/    |    |  |  |    |      |    |  |  |     /   \     |    \     |    |    |     |      /  _]    |   \  
|  o  |    |  |  |    |      |    |  |  |    |     |    |  D  )     |  |     |__/  |     /  [_     |    \ 
|     |    |  |  |    |_|  |_|    |  _  |    |  O  |    |    /      |  |     |   __|    |    _]    |  D  |
|  _  |    |  :  |      |  |      |  |  |    |     |    |    \      |  |     |  /  |    |   [_     |     |
|  |  |    |     |      |  |      |  |  |    |     |    |  .  \     |  |     |     |    |     |    |     |
|__|__|     \__,_|      |__|      |__|__|     \___/     |__|\_|    |____|    |_____|    |_____|    |_____|
                                                                                                        
                                       
\n
";
}
login($admin);
// Main loop for user commands
while (true) {
  echo "Commands:\n";
  echo colorize("1. Add Credentials\n", 'green');
  echo colorize("2. Get Credentials\n", 'blue');
  echo colorize("3. Change Admin Password\n", 'yellow');
  echo colorize("4. Exit\n", 'red');

  $choice = readline("Enter your choice: ");

  switch ($choice) {
    case "1":
      $website = readline("Enter website: ");
      $email = readline("Enter email: ");
      $password = readline("Enter password: ");
      addPassword($passwords, $website, $email, $password);
      break;
    case "2":
      $website = readline("Enter website: ");
      $credentials = getPassword($passwords, $website);
      if ($credentials !== null) {
        echo "Email for $website: " . $credentials["email"] . "\n";
        echo "Password for $website: " . $credentials["password"] . "\n";
      }
      break;
    case "3":
      $oldpassword = readline("Enter old password: ");
      $newusername = readline("Enter new username: ");
      $newpassword = readline("Enter new password: ");
      changeAdminPassword($admin, $oldpassword, $newusername, $newpassword);
      login($admin);
      break;
    case "4":
      echo "Exiting...\n";
      exit(0);
    default:

      echo "Invalid choice. Please try again.\n";
  }
}
