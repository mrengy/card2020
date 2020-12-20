jQuery(document).ready(function($){
  var dictionary = new Typo("en_US", false, false, { dictionaryPath: neve_child_stylesheet_directory['stylesheet_directory_uri']+"/js/vendor/typo/dictionaries" });
  var comment_raw = '';
  var comment_stripped = '';
  var words = [];
  var is_spelled_correctly;
  $("#comment").on("input", function(){
        comment_raw = ($(this).val());
        comment_stripped = comment_raw.replace(/[^\w\s]|_/g, "").replace(/\n/g, " ").replace(/\s+/g, " ");
        words = comment_stripped.split(' ');
        /*
        console.log('comment raw = '+comment_raw);
        console.log('comment stripped = '+comment_stripped);
        console.log(words);
        */
        $.each(words, function(index, item){
          is_spelled_correctly = dictionary.check(this);
          console.log(index+' = '+is_spelled_correctly);
        })
  });
  /*
  var is_spelled_correctly = dictionary.check("mispelled");
  console.log(is_spelled_correctly);
  */
});
