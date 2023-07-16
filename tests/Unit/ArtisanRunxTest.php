<?php

namespace Monurakkaya\ArtisanRunx\Tests;

final class ArtisanRunxTest extends TestCase
{
    /** @test */
    public function it_runs_single_command(): void
    {
        $this->artisan('runx', ['--commands' => 'inspire'])->assertSuccessful();
    }

    /** @test */
    public function it_runs_single_command_with_args(): void
    {
        $this->artisan('runx', ['--commands' => 'manage-foo create'])->assertSuccessful();
        $this->assertEquals(11, Foo::count());
    }

    /** @test */
    public function it_runs_single_command_with_args_and_options(): void
    {
        $this->artisan('runx', ['--commands' => 'manage-foo delete --id=1'])->assertSuccessful();
        $this->assertEquals(9, Foo::count());
    }

    /** @test */
    public function it_runs_multiple_command_with_args_and_options(): void
    {
        $this->artisan('runx', ['--commands' => 'inspire && manage-foo delete --id=2'])->assertSuccessful();
        $this->assertEquals(9, Foo::count());
    }

    /** @test */
    public function it_fails_when_command_is_not_defined(): void
    {
        $this->artisan('runx', ['--commands' => uniqid('fake_command')])->assertFailed();
    }

    /** @test */
    public function it_should_print_correct_output(): void
    {
        $this->artisan('runx', ['--commands' => uniqid('not_defined_command')])
            ->assertFailed()
            ->expectsOutputToContain('Running command: not_defined_command')
            ->expectsOutputToContain('Artisan RunX Summary:')
            ->expectsTable(['Success', 'Failed'],
                [
                    [0, 1],
                ],
                'box-double');
    }
}
