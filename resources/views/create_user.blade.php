<x-layout>
    <section class="">
        <main class="">

                <h1 class="">Register</h1>

                <form method="POST" action="/register" class="mt-10">
                    @csrf

                    <input class="" name="name"
                           id="name" required
                    >
                    <input class="" name="username"
                           id="username" required
                    >
                    <input class="" name="email"
                           id="email" required
                    >
                    <input class="" name="password"
                           id="password" required
                    >
                    {{--<x-form.input name="name" required />
                    <x-form.input name="username" required />
                    <x-form.input name="email" type="email" required />
                    <x-form.input name="password" type="password" autocomplete="new-password" required />--}}
                   <button type="submit"
                    class=""
                    >Sign Up</button>
                </form>

        </main>
    </section>
</x-layout>
