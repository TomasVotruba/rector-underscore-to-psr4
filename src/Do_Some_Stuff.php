<?php

declare(strict_types=1);

final class Do_Some_Stuff
{
    public function test(): DateTimeInterface
    {
        return new DateTimeImmutable('now');
    }
}
