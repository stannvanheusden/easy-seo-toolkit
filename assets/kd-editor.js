jQuery('document').ready(function(){
    setInterval(function () {

        var text = jQuery('.edit-post-visual-editor').text();
        var text_lc = text.toLowerCase();

        var word_list = text_lc.split(/\W+/); // Split the text into words.
        var counts = {};

        for (var i = 0; i < word_list.length; ++i) {
            var word = word_list[i];
            counts[word] = (counts[word] || 0) + 1; // Increment count by one.
        }

        var densities = new Array();


        /* Focus keyword: */
        var i = 0;
        var focuskw = jQuery('._est_seo_kd').val();
        var focuskw_lc = focuskw.toLowerCase();
        var focuskw_array = focuskw_lc.split(',');

            jQuery.each( focuskw_array, function(focuskw_arr, focuskw_array) {
                var est_kdocc = jQuery(".edit-post-visual-editor:contains('" + focuskw_array + "')").size();
                focuskw_arr;
                var calculatedKD = parseFloat(( est_kdocc / word_list.length) * 100).toFixed(2);
                densities.push('<div class="kd-checker"><div class="kd-word">' + focuskw_array + '</div><div class="kd-density">' + calculatedKD + '%</div><div class="kd-status"><span class="kd-word-status"></span></div></div>'); // Calculates all the densities percentage.
            });
            jQuery('span.kd').html(densities);
    },3600);

});


