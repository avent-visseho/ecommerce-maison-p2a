<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.new_blog_post.title') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #2725a9; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">{{ __('emails.new_blog_post.title') }}</h1>
        <p style="margin: 5px 0 0 0;">{{ __('emails.new_blog_post.subtitle') }}</p>
    </div>

    <div style="background-color: #f4f4f4; padding: 30px; margin-top: 20px;">
        <h2 style="color: #2725a9;">{{ __('emails.new_blog_post.new_post_published') }}</h2>

        <p>{{ __('emails.new_blog_post.hello') }},</p>

        <p>{{ __('emails.new_blog_post.new_article_published') }}</p>

        <div style="background-color: white; padding: 20px; margin: 20px 0; border-left: 4px solid #2725a9;">
            <h3 style="margin-top: 0; color: #2725a9;">{{ $post->title }}</h3>

            @if($post->excerpt)
                <p style="color: #666;">{{ $post->excerpt }}</p>
            @endif

            <p style="font-size: 14px; color: #999;">
                {{ __('emails.new_blog_post.by') }} {{ $post->author->name }} | {{ $post->published_at->format('d/m/Y') }}
            </p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('blog.show', $post->slug) }}"
               style="background-color: #2725a9; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                {{ __('emails.new_blog_post.read_article') }}
            </a>
        </div>

        <p style="font-size: 12px; color: #666;">
            {{ __('emails.new_blog_post.newsletter_notice') }}
            <a href="{{ route('newsletter.unsubscribe', $subscriber->token) }}" style="color: #2725a9;">{{ __('emails.new_blog_post.unsubscribe') }}</a>
        </p>
    </div>

    <div style="text-align: center; margin-top: 20px; padding: 20px; font-size: 12px; color: #666;">
        <p>&copy; {{ date('Y') }} La Maison P2A. {{ __('emails.new_blog_post.all_rights_reserved') }}.</p>
    </div>
</body>
</html>
