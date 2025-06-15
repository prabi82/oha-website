(function(){
    wp.domReady(function(){
        if(!wp.blocks||!wp.blocks.registerBlockVariation) return;
        wp.blocks.registerBlockVariation('core/latest-posts',{
            name:'oha-latest-videos',
            title:'Latest Videos',
            description:'Display a list of your most recent videos.',
            icon:'video-alt3',
            attributes:{
                postType:'oha_video',
                displayFeaturedImage:true,
                displayPostDate:false
            },
            isActive: function(blockAttributes){
                return blockAttributes.postType==='oha_video';
            }
        });
    });
})(); 