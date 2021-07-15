<?php

use Buchin\SentenceFinder\SentenceFinder;

describe("SentenceFinder", function () {
    given("sf", function () {
        return new SentenceFinder();
    });

    describe("->findSentence()", function () {
        it("should return string ", function () {
            $sentences = $this->sf->findSentence("makan nasi");
            expect(is_string($sentences[0]))->toBe(true);
        });
    });
});
