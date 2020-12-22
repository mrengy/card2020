jQuery(document).ready(function($){
  var vocab = $.getJSON(neve_child_stylesheet_directory['stylesheet_directory_uri']+'/js/vocab.json', function(obj) {
  });

  var incorrect_words = [];
  //check words input in comment field against vocab
  $("#comment").on("input", function(){
      var comment_raw = ($(this).val());
      var comment_stripped = comment_raw.replace(/[^\w\s]|_/g, "").replace(/\n/g, " ").replace(/\s+/g, " ");
      var words = [];
      words = comment_stripped.split(' ');
      //reset incorrect_words
      incorrect_words = [];

      $.each(words, function(index, item){
        var is_in_vocab = false;
        for (var i = 0; i < vocab.responseJSON.word.length; ++i){
          var thisWord = vocab.responseJSON.word[i].name;
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
        //console.log(incorrect_words);
      })
  });

  $('#commentform').submit(function(e){
    if (incorrect_words.length > 0){
      console.log(incorrect_words.length);
      e.preventDefault();
      var string_incorrect_words = (incorrect_words.join(', '));
      
      console.log("Sorry. \""+string_incorrect_words+"\" is not in Myron's vocabulary yet.");
    }
  })
});
