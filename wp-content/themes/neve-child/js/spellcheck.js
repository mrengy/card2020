jQuery(document).ready(function($){
  var vocab = $.getJSON(neve_child_stylesheet_directory['stylesheet_directory_uri']+'/js/vocab.json', function(obj) {
  });

  //use jquery validate
  $('#commentform').validate({
    debug: true
  });

  //check words input in comment field against vocab
  $("#comment").on("input", function(){
      var comment_raw = ($(this).val());
      var comment_stripped = comment_raw.replace(/[^\w\s]|_/g, "").replace(/\n/g, " ").replace(/\s+/g, " ");
      var words = [];
      words = comment_stripped.split(' ');
      var incorrect_words = [];
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
        console.log(incorrect_words);
      })
  });

});
