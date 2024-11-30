<x-mails.header>Welcome Onboard</x-mails.header>
<x-mails.body>
    <x-slot name="bodyTitle">
        <x-mails.body-title>Welcome Onboard</x-mails.body-title>
    </x-slot>
    <x-slot name="bodyContent">
        <x-mails.body-content>
            <x-mails.salutation>Hi {{ $data['user']->name ?? 'there' }} 👋🏼,</x-mails.salutation>
            <x-mails.spacer />

            <x-mails.paragraph>Welcome to {{env('APP_NAME')}}!
                We're so excited to have you on board.
            </x-mails.paragraph>

            <x-mails.spacer />

        </x-mails.body-content>
    </x-slot>
</x-mails.body>
<x-mails.footer>
    <x-slot name="footerSocialIcons">
        <x-mails.footer-social-icons></x-mails.footer-social-icons>
    </x-slot>
</x-mails.footer>
