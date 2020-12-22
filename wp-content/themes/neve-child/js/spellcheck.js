jQuery(document).ready(function($){
  var dictionary = new Typo("en_US", false, false, { dictionaryPath: neve_child_stylesheet_directory['stylesheet_directory_uri']+"/js/vendor/typo/dictionaries" });

  var vocab = $.getJSON(neve_child_stylesheet_directory['stylesheet_directory_uri']+'/js/vocab.json', function(obj) {
  });

  $("#comment").on("input", function(){
      var comment_raw = ($(this).val());
      var comment_stripped = comment_raw.replace(/[^\w\s]|_/g, " ").replace(/\n/g, " ").replace(/\s+/g, " ");
      var words = [];
      words = comment_stripped.split(' ');
      var incorrect_words = [];
      /*
      console.log('comment raw = '+comment_raw);
      console.log('comment stripped = '+comment_stripped);
      console.log(words);
      */
      $.each(words, function(index, item){
        var is_in_vocab = false;
        //console.log(vocab.responseJSON);
        for (var i = 0; i < vocab.responseJSON.word.length; ++i){

          var thisWord = vocab.responseJSON.word[i].name;
          //console.log(thisWord);
          if(thisWord.toUpperCase()===this.toUpperCase()){
            is_in_vocab = true;
            break;
          }
          //when we are checking the last word in the vocab, if it doesn't match the word typed
          else if(i == (vocab.responseJSON.word.length - 1) && thisWord.toUpperCase()!=this.toUpperCase()) {
            incorrect_words.push(this);
          }
        }

        // show whether each number word in the comment is in the vocab
        //console.log(index+' = '+is_in_vocab);

        console.log(incorrect_words);
        /*
        is_spelled_correctly = dictionary.check(this);
        console.log(index+' = '+is_spelled_correctly);
        */
      })
  });
});
