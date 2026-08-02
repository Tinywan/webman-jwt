<?php

declare(strict_types=1);

use Tinywan\Jwt\Exception\JwtTokenException;
use Tinywan\Jwt\JwtToken;

it('generates access and refresh tokens', function (): void {
    $token = JwtToken::generateToken([
        'id' => 2022,
        'name' => 'Tinywan',
        'email' => 'Tinywan@163.com',
    ]);

    expect($token)
        ->toBeArray()
        ->toHaveKeys(['token_type', 'expires_in', 'access_token', 'refresh_token'])
        ->and($token['token_type'])
        ->toBe('Bearer')
        ->and($token['expires_in'])
        ->toBe(7200);
});

it('verifies a generated access token', function (): void {
    $token = JwtToken::generateToken(['id' => 2022, 'role' => 'admin']);
    $payload = JwtToken::verify(1, $token['access_token']);

    expect($payload['extend'])
        ->toMatchArray(['id' => 2022, 'role' => 'admin'])
        ->and($payload['iss'])
        ->toBe('webman-jwt.test');
});

it('honors a custom access token lifetime', function (): void {
    $token = JwtToken::generateToken(['id' => 2022, 'access_exp' => 1800]);

    expect($token['expires_in'])->toBe(1800);
});

it('requires a globally unique id', function (): void {
    JwtToken::generateToken(['name' => 'Tinywan']);
})->throws(JwtTokenException::class, '缺少全局唯一字段：id');

it('clears successfully when single-device login is disabled', function (): void {
    expect(JwtToken::clear())->toBeTrue();
});
