<?php

it('can get regency by id')->get('/api/regency?id=1101')
                            ->assertStatus(200)
                            ->assertJsonFragment(['id' => 1101])
                            ->assertJsonStructure([
                                "data" => [
                                    "id","name","province_id"
                                ]
                            ]);
it('can get regency by keyword')->get('/api/regency?keyword=mal')
                                ->assertStatus(200)
                                ->assertJsonStructure([
                                    "data" => [
                                        "*" => [
                                            "id", "name"
                                        ]
                                    ]
                                ]);
it('can response false parameter')->get('/api/regency?abc')->assertStatus(422);
it('can response not found')->get('/api/regency?id=1')->assertStatus(404);
