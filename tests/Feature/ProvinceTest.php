<?php

it('can get province by id')->get('/api/province?id=11')
                            ->assertStatus(200)
                            ->assertJsonFragment(["id" => 11]);

it('can get province by keyword')->get('/api/province?keyword=mal')
                                    ->assertStatus(200)
                                    ->assertJsonStructure([
                                        "data" => [
                                            "*" => [
                                                "id", "name"
                                            ]
                                        ]
                                    ]);

it('can response false parameter')->get('/api/province?abc')->assertStatus(422);

it('can response not found')->get('/api/regency?id=1')->assertStatus(404);
