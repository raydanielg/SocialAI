<?php

return [
    // This API converts text to images.

    'image_api_url' => env('STABLE_DIFFUSION_API_MODE') == 'stage' ? 'https://stablediffusionapi.com/api/v3/text2img' : 'https://stablediffusionapi.com/api/v1/enterprise/text2img',

    // This API converts text to videos.
    'video_api_url' => env('STABLE_DIFFUSION_API_MODE') == 'stage' ? 'https://stablediffusionapi.com/api/v5/text2video' : 'https://stablediffusionapi.com/api/v1/enterprise/text2video',

    // This API converts text to voice.
    'voice_clone_api_url' => 'https://stablediffusionapi.com/api/v5/text_to_voice',

    // This API converts text to audio.
    'audio_api_url' => 'https://stablediffusionapi.com/api/v5/text_to_audio',
    // fetch url.
    'fetch_api_url' => 'https://stablediffusionapi.com/api/v3/fetch/',

    // The IDs for the voice clones. These are used to specify the voice for the text to voice conversion.
    'voice_clone_ids' => ['jack_sparrow', 'tom_hank'],
];
