# cosmira/envelope

[![Tests](https://github.com/cosmira/envelope/actions/workflows/phpunit.yml/badge.svg)](https://github.com/cosmira/envelope/actions/workflows/phpunit.yml)
[![Quality Assurance](https://github.com/cosmira/envelope/actions/workflows/quality.yml/badge.svg)](https://github.com/cosmira/envelope/actions/workflows/quality.yml)
[![Coding Guidelines](https://github.com/cosmira/envelope/actions/workflows/code-style.yml/badge.svg)](https://github.com/cosmira/envelope/actions/workflows/code-style.yml)

## Introduction

An elegant PHP library for parsing and extracting structured email contents, including attachments, headers, and metadata. Built on top of the powerful [ZBateson\MailMimeParser](https://github.com/ZBateson/MailMimeParser) package, it offers a clean and intuitive API that simplifies working with email data.

## Installation

You can install the package via Composer:

```bash
composer require cosmira/envelope
```

## Usage

To use the `Envelope` class, instantiate it with raw email content.

```php
use Cosmira\Envelope\Envelope;

$content = file_get_contents('path_to_email_file.eml');

$mail = new Envelope($content);
```

## API Reference

### `from()`

Get the sender’s email address.

```php
$mail->from();
// "john@example.com"
```


### `fromName()`

Get the sender’s display name.

```php
$mail->fromName();
// "John Doe"
```

### `to()`

Get the primary recipients as an array of `email => name` pairs.

```php
$mail->to();
// Collection: ['jane@example.com' => 'Jane Doe']
```

### `cc()`

Get the CC recipients as an array of `email => name` pairs.

```php
$mail->cc();
// Collection: ['assistant@example.com' => 'Team Assistant']
```

### `bcc()`

Get the BCC recipients as an array of `email => name` pairs.

```php
$mail->bcc();
// Collection: ['hidden@example.com' => 'Confidential']
```

### `subject()`

Get the subject line of the email.

```php
$mail->subject();
// "Project Kickoff Meeting"
```

### `date()`

Get the date the email was sent as a `DateTime` object.

```php
$mail->date()->format('Y-m-d H:i:s');
// "2025-09-11 10:32:00"
```

### `text()`

Get the plain text content of the email.

```php
$mail->text();
// "Hello team, the meeting is scheduled for tomorrow..."
```

### `html()`

Get the HTML content of the email.

```php
$mail->html();
// "<p>Hello team,<br>The meeting is scheduled for tomorrow...</p>"
```

### `attachments()`

Get all attachments as an array, with each item containing `name`, `mime`, and `content`.

```php
// Get all attachments in the email
$attachments = $mail->attachments();

// Loop through attachments and get information about each
foreach ($attachments as $attachment) {
    echo 'Filename: ' . $attachment['name'] . PHP_EOL;
    echo 'MIME Type: ' . $attachment['mime'] . PHP_EOL;
    echo 'Content: ' . $attachment['content'] . PHP_EOL;
}
```
