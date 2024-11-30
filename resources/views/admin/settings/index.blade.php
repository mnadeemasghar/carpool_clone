<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Key</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- General Settings -->
                                <tr class="table-primary">
                                    <td colspan="3"><strong>General Settings</strong></td>
                                </tr>
                                <tr>
                                    <td>Application Name</td>
                                    <td>app-name</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>Site URL</td>
                                    <td>site-url</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>Support Email</td>
                                    <td>support-email</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>

                                <!-- Email Settings -->
                                <tr class="table-primary">
                                    <td colspan="3"><strong>Email Settings</strong></td>
                                </tr>
                                <tr>
                                    <td>SMTP Host</td>
                                    <td>smtp-host</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>SMTP Port</td>
                                    <td>smtp-port</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>SMTP Username</td>
                                    <td>smtp-username</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>SMTP Password</td>
                                    <td>smtp-password</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>

                                <!-- API Keys -->
                                <tr class="table-primary">
                                    <td colspan="3"><strong>API Keys</strong></td>
                                </tr>
                                <tr>
                                    <td>Google API Key</td>
                                    <td>google-api-key</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>Facebook API Key</td>
                                    <td>facebook-api-key</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>Twitter API Key</td>
                                    <td>twitter-api-key</td>
                                    <td><a href="" class="btn btn-warning">Edit</a></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>