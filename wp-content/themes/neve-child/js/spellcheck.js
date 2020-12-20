jQuery(document).ready(function($){
  var dictionary = new Typo("en_US", false, false, { dictionaryPath: neve_child_stylesheet_directory['stylesheet_directory_uri']+"/js/vendor/typo/dictionaries" });
  var comment_raw = '';
  var comment_stripped = '';
  $("#comment").on("input", function(){
        comment_raw = ($(this).val());
        //console.log(comment_raw);
        comment_stripped = JSON.stringify(comment_raw).replace(/[^\w\s]|_/g, "").replace(/\s+/g, " ");
        console.log('comment stripped = '+comment_stripped);
        console.log('comment raw = '+comment_raw);
  });
  /*
  var is_spelled_correctly = dictionary.check("mispelled");
  console.log(is_spelled_correctly);
  */
});
