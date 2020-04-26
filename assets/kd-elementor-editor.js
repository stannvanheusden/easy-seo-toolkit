jQuery('document').ready(function(){
    setInterval(function () {
        
        if(jQuery('.elementor-control-seo_section').hasClass('elementor-open') ) {
        

                var est_iframe = document.getElementById('elementor-preview-iframe');
                var est_iframeDocument = est_iframe.contentDocument || est_iframe.contentWindow.document;
                var est_iframeContent = est_iframeDocument.body;

                var text =  est_iframeContent.textContent;
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
                var focuskw = jQuery('.elementor-control-_est_seo_focuskw input').val();
                // focuskw = focuskw.replace(/\s+/g, '');
                var focuskw_lc = focuskw.toLowerCase();
                var focuskw_array = focuskw_lc.split(',');
                var est_kdocc = '';

                    jQuery.each( focuskw_array, function(focuskw_arr, focuskw_array) {
                        est_kdocc = jQuery(text_lc + ":contains('" + focuskw_array + "')").size();
                        focuskw_arr;
                        var calculatedKD = parseFloat(( est_kdocc / word_list.length) * 100).toFixed(2);
                        densities.push('<div class="kd-checker elementor-control"><div class="kd-word elementor-control-title">' + focuskw_array + '</div><div class="kd-density elementor-control-input-wrapper">' + calculatedKD + '%</div><div class="kd-status"><span class="kd-word-status"></span></div></div>'); // Calculates all the densities percentage.
                    });
                    jQuery('span.kd').html(densities);
                    
                }
		
    },3600);

});