<?php

it('can get district by id')->get('/api/district?id=110101')
                            ->assertStatus(200)
                            ->assertJsonFragment(['id' => 110101])
                            ->assertJsonStructure([
                                "data" => [
                                    "id","name","regency_id","province_id"
                                ]
                            ]);

it('can get district by keyword')->get('/api/district?keyword=mal')
                                    ->assertStatus(200)
                                    ->assertJsonStructure([
                                        "data" => [
                                            "*" => [
                                                "id", "name"
                                            ]
                                        ]
                                    ]);

it('can response false parameter')->get('/api/district?abc')->assertStatus(422);

it('can response not found')->get('/api/district?id=1')->assertStatus(404);
