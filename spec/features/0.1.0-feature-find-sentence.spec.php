<?php
use Buchin\SentenceFinder\SentenceFinder;
describe('Feature: Find Sentence', function(){
	context('User Story:', function(){
		describe('As a user', function(){});
		describe('I want to find sentence using given word', function(){});
		describe('So I don\'t have to browse it manually', function(){});
	});	

	context('Scenario:', function(){
		given('word', function(){
			return 'makan nasi';
		});

		given('finder', function(){
			return new SentenceFinder;
		});

		describe('User find sentence using given word', function(){
			it('should returns array of sentence', function(){
				$sentences = $this->finder->findSentence($this->word);
				expect($sentences)->toBeA('array');
				expect(strtolower($sentences[0]))->toContain($this->word);
			});
		});
	});
});