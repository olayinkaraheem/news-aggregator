<x-mails.header>OTP Code</x-mails.header>
<x-mails.body>
    <x-slot name="bodyTitle">
        <x-mails.body-title>OTP Code</x-mails.body-title>
    </x-slot>
    <x-slot name="bodyContent">
        <x-mails.body-content>
            <x-mails.salutation>Dear {{ $data['user']->name ?? 'User' }},</x-mails.salutation>
            <x-mails.spacer />
            <x-mails.paragraph>
                To complete the email verification process and ensure the security of your {{env('APP_NAME')}} account, we
                have sent you a verification code:
            </x-mails.paragraph>
            <x-mails.spacer />
            <h3
                style="color:#313C49; font-family: Sora; font-size: 20px; font-style: normal; font-weight: 700; line-height: normal;">
                {{ $data['code'] }}
            </h3>
            <x-mails.spacer />
            <x-mails.paragraph>
                Please use this code to verify your account.
            </x-mails.paragraph>
            <x-mails.spacer />
            <x-mails.paragraph>
                This code is valid until {{ $data['expiresAt'] }}. If you do not use it within this time frame,
                you may need to request a new code.
            </x-mails.paragraph>
            <x-mails.spacer />
            <x-mails.paragraph>
                Your security is important to us. Please do not share this code with anyone, and avoid responding to
                any requests for this code from unknown sources.
            </x-mails.paragraph>
            <x-mails.spacer />
            <x-mails.paragraph>
                If you did not register with {{env('APP_NAME')}} or have any concerns about your account's security, please contact
                our support team
                immediately at <a href="mailto:hello@news-aggregator.com" target="_blank"
                    style="color: #398DFA; text-decoration: none;">hello@news-aggregator.com</a>.
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
