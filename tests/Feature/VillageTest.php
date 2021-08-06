<?php

it('can get village by id')->get('/api/village?id=1101012001')
                            ->assertStatus(200)
                            ->assertJsonFragment(['id' => 1101012001])
                            ->assertJsonStructure([
                                "data" => [
                                    "id","name","zip_code","district_id","regency_id","province_id"
                                ]
                            ]);

it('can get village by keyword')->get('/api/village?keyword=mal')
                                ->assertStatus(200)
                                ->assertJsonStructure([
                                    "data" => [
                                        "*" => [
                                            "id", "name"
                                        ]
                                    ]
                                ]);

it('can response false parameter')->get('/api/village?abc')->assertStatus(422);

it('can response not found')->get('/api/village?id=1')->assertStatus(404);
