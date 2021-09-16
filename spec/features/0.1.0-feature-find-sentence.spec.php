<?php
namespace Buchin\SentenceFinder;

describe("Feature: Find Sentence", function () {
    context("User Story:", function () {
        describe("As a user", function () {});
        describe("I want to find sentence using given word", function () {});
        describe('So I don\'t have to browse it manually', function () {});
    });

    context("Scenario:", function () {
        given("word", function () {
            return "makan nasi";
        });

        describe("User find sentence using given word", function () {
            $finders = ["Ask", "Bing"];

            it(
                "is using SentenceFinder and should returns array of sentence",
                function () {
                    $sentences = (new SentenceFinder())->findSentence(
                        $this->word
                    );

                    expect($sentences)->toBeA("array");
                    expect(strtolower($sentences[0]))->toBeA("string");
                }
            );

            foreach ($finders as $finder) {
                it(
                    "is using $finder and should returns array of sentence",
                    function () use ($finder) {
                        $finder = "\\Buchin\\SentenceFinder\\" . $finder;

                        $sentences = (new $finder())->get($this->word);
                        expect($sentences)->toBeA("array");
                        expect(strtolower($sentences[0]))->toBeA("string");
                    }
                );
            }
        });
    });
});
