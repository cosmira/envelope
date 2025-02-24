<?php

namespace Cosmira\Envelope\Tests;

use Cosmira\Envelope\Envelope;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use ZBateson\MailMimeParser\Message;

class EnvelopeTest extends TestCase
{
    private string $emailContent = <<<'EOL'
From: John Doe <john@example.com>
To: Jane Doe <jane@example.com>
CC: Jack Doe <jack@example.com>
BCC: Jim Doe <jim@example.com>
Subject: Test Email
Date: Mon, 25 Sep 2023 12:34:56 +0000
MIME-Version: 1.0
Content-Type: multipart/mixed; boundary="boundary"

--boundary
Content-Type: text/plain; charset="UTF-8"

This is the plain text part.

--boundary
Content-Type: text/html; charset="UTF-8"

<html><body><p>This is the HTML part.</p></body></html>

--boundary
Content-Type: application/pdf
Content-Disposition: attachment; filename="document.pdf"
Content-Transfer-Encoding: base64

JVBERi0xLjQKJ...

--boundary--
EOL;

    public function test_can_create_envelope_instance(): void
    {
        $envelope = new Envelope($this->emailContent);
        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function test_can_get_from_email(): void
    {
        $envelope = new Envelope($this->emailContent);
        $this->assertEquals('john@example.com', $envelope->from());
    }

    public function test_can_get_from_name(): void
    {
        $envelope = new Envelope($this->emailContent);
        $this->assertEquals('John Doe', $envelope->fromName());
    }

    public function test_can_get_to_recipients(): void
    {
        $envelope = new Envelope($this->emailContent);
        $expected = collect(['jane@example.com' => 'Jane Doe']);
        $this->assertInstanceOf(Collection::class, $envelope->to());
        $this->assertEquals($expected, $envelope->to());
    }

    public function test_can_get_cc_recipients(): void
    {
        $envelope = new Envelope($this->emailContent);
        $expected = collect(['jack@example.com' => 'Jack Doe']);
        $this->assertInstanceOf(Collection::class, $envelope->cc());
        $this->assertEquals($expected, $envelope->cc());
    }

    public function test_can_get_bcc_recipients(): void
    {
        $envelope = new Envelope($this->emailContent);
        $expected = collect(['jim@example.com' => 'Jim Doe']);
        $this->assertInstanceOf(Collection::class, $envelope->bcc());
        $this->assertEquals($expected, $envelope->bcc());
    }

    public function test_can_get_subject(): void
    {
        $envelope = new Envelope($this->emailContent);
        $this->assertEquals('Test Email', $envelope->subject());
    }

    public function test_can_get_date(): void
    {
        $envelope = new Envelope($this->emailContent);
        $this->assertInstanceOf(\DateTime::class, $envelope->date());
        $this->assertEquals('2023-09-25 12:34:56', $envelope->date()->format('Y-m-d H:i:s'));
    }

    public function test_can_get_text_content(): void
    {
        $envelope = new Envelope($this->emailContent);
        $this->assertEquals('This is the plain text part.', trim($envelope->text()));
    }

    public function test_can_get_html_content(): void
    {
        $envelope = new Envelope($this->emailContent);
        $expectedHtml = '<html><body><p>This is the HTML part.</p></body></html>';
        $this->assertEquals($expectedHtml, trim($envelope->html()));
    }

    public function test_can_get_attachments(): void
    {
        $envelope = new Envelope($this->emailContent);
        $attachments = $envelope->attachments();

        $this->assertInstanceOf(Collection::class, $attachments);
        $this->assertCount(1, $attachments);

        $expected = [
            'name'    => 'document.pdf',
            'mime'    => 'application/pdf',
            'content' => "%PDF-1.4\n",
        ];

        $this->assertEquals($expected, $attachments->first());
    }

    public function test_can_get_original_message(): void
    {
        $envelope = new Envelope($this->emailContent);
        $this->assertInstanceOf(Message::class, $envelope->originalMessage());
    }
}
