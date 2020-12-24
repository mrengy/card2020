jQuery(document).ready(function($){
  var vocab = $.getJSON(neve_child_stylesheet_directory['stylesheet_directory_uri']+'/js/vocab.json', function(obj) {
  });

  var incorrect_words = [];
  //check words input in comment field against vocab
  function checkwords(){

    var comment_raw = $(this).val();
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
        else if(i == (vocab.responseJSON.word.length - 1) && thisWord.toUpperCase()!=this.toUpperCase() && this.length > 0){
          incorrect_words.push(this);
        }
      }
      // show whether each number word in the comment is in the vocab
      //console.log(index+' = '+is_in_vocab);
      //console.log(incorrect_words);
    })
  };

  function throwerrors(event){
    //reset errors
    $('#comment-error').remove();
    $('#comment').removeClass('has-error');

    if (incorrect_words.length > 0){
      if(event != null){
        if(event.type == 'submit'){
            event.preventDefault();
        }
      }
      var string_incorrect_words = (incorrect_words.join(', '));

      var error_message ="Sorry. \""+string_incorrect_words+"\" is not in Myron's vocabulary yet.";

      $('#comment').addClass('has-error');
      $('#comment').after(
        ' <label id = "comment-error" class="error" for="comment"> '
        + error_message
        +'</label>'
      );
    }
  };

  $('#comment').on('input', checkwords);
  $('#comment').on('blur', throwerrors);
  $('#comment').keyup(function(e){
    //if space is pressed
    if(e.which === 32){
      throwerrors();
    }
  });

  $('#commentform').submit(throwerrors);
});
