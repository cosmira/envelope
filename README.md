# Cosmira\Envelope

[![Tests](https://github.com/cosmira\envelope/actions/workflows/phpunit.yml/badge.svg)](https://github.com/cosmira\envelope/actions/workflows/phpunit.yml)
[![Quality Assurance](https://github.com/cosmira\envelope/actions/workflows/quality.yml/badge.svg)](https://github.com/cosmira\envelope/actions/workflows/quality.yml)
[![Coding Guidelines](https://github.com/cosmira\envelope/actions/workflows/code-style.yml/badge.svg)](https://github.com/cosmira\envelope/actions/workflows/php-cs-fixer.yml)

## Introduction

An elegant PHP library for parsing and extracting structured email contents, including attachments, headers, and metadata. Built on top of the powerful [ZBateson\MailMimeParser](https://github.com/ZBateson/MailMimeParser) package, it offers a clean and intuitive API that simplifies working with email data.

## Installation

You can install the package via Composer:

```bash
composer require cosmira/envelope
```

## Usage

### Basic Usage

To use the `Envelope` class, instantiate it with raw email content. Then, use the various methods to access parts of the email such as the sender, recipients, subject, and more.

```php
use Cosmira\Envelope\Envelope;

$emailContent = file_get_contents('path_to_email_file.eml');

// Parse the email content
$mailParser = Envelope::fromString($emailContent);

// Retrieve the sender's email address
$from = $mailParser->from();

// Retrieve the recipient(s) in the "To" field
$to = $mailParser->to();

// Retrieve the email subject
$subject = $mailParser->subject();

// Retrieve the plain text content
$textContent = $mailParser->text();

// Retrieve the HTML content
$htmlContent = $mailParser->html();

// Retrieve the attachments
$attachments = $mailParser->attachments();
```

### Available Methods

Here are the methods you can use with the `Envelope` class:

- `from()` – Get the sender's email address.
- `fromName()` – Get the sender's name.
- `to()` – Get the "To" recipients, as an array of email => name pairs.
- `cc()` – Get the "CC" recipients, as an array of email => name pairs.
- `bcc()` – Get the "BCC" recipients, as an array of email => name pairs.
- `subject()` – Get the subject of the email.
- `date()` – Get the date the email was sent as a `DateTimeImmutable` object.
- `text()` – Get the plain text content of the email.
- `html()` – Get the HTML content of the email.
- `attachments()` – Get a collection of attachments with filenames, MIME types, and content.

### Example: Retrieving All Recipients

```php
// Get the "To" field recipients
$toRecipients = $mailParser->to();

// Get the "CC" field recipients
$ccRecipients = $mailParser->cc();

// Get the "BCC" field recipients
$bccRecipients = $mailParser->bcc();
```

### Example: Retrieving Attachments

```php
// Get all attachments in the email
$attachments = $mailParser->attachments();

// Loop through attachments and get information about each
foreach ($attachments as $attachment) {
    echo 'Filename: ' . $attachment['name'] . PHP_EOL;
    echo 'MIME Type: ' . $attachment['mime'] . PHP_EOL;
    echo 'Content: ' . $attachment['content'] . PHP_EOL;
}
```
