<?php

namespace Tests\Unit\Domain\ShortUrl\Services;

use App\Domain\ShortUrl\Services\ShortCodeGenerator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShortCodeGeneratorTest extends TestCase
{
    #[Test]
    public function it_encodes_numbers_in_base62(): void
    {
        $generator = new ShortCodeGenerator;

        $this->assertSame('1', $generator::encode(1));
        $this->assertSame('10', $generator::encode(62));
        $this->assertSame('100', $generator::encode(3844));
    }

    #[Test]
    public function it_generates_codes_of_requested_length(): void
    {
        $generator = new ShortCodeGenerator;

        $code = $generator->generate(7);

        $this->assertSame(7, strlen($code));
        $this->assertMatchesRegularExpression('/^[0-9a-zA-Z]{7}$/', $code);
    }
}
