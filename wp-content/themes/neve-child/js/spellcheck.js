jQuery(document).ready(function($){
  var dictionary = new Typo("en_US", false, false, { dictionaryPath: neve_child_stylesheet_directory['stylesheet_directory_uri']+"/js/vendor/typo/dictionaries" });

  var vocab = $.getJSON(neve_child_stylesheet_directory['stylesheet_directory_uri']+'/js/vocab.json', function(obj) {
      console.log(obj);
  });

  $("#comment").on("input", function(){
      var comment_raw = ($(this).val());
      var comment_stripped = comment_raw.replace(/[^\w\s]|_/g, " ").replace(/\n/g, " ").replace(/\s+/g, " ");
      var words = [];
      words = comment_stripped.split(' ');
      /*
      console.log('comment raw = '+comment_raw);
      console.log('comment stripped = '+comment_stripped);
      console.log(words);
      */
      $.each(words, function(index, item){

        //console.log(vocab.responseJSON);
        for (var i = 0; i < vocab.responseJSON.word.length; ++i){
          var is_in_vocab = false;
          var thisWord = vocab.responseJSON.word[i].name;
          //console.log(thisWord);
          if(thisWord=this){
            is_in_vocab = true;
            break;
          }
        }
        console.log(index+' = '+is_in_vocab);
        /*
        is_spelled_correctly = dictionary.check(this);
        console.log(index+' = '+is_spelled_correctly);
        */
      })
  });
});
