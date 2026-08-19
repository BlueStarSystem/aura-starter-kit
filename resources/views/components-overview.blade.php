<x-layouts.app title="Components">
    <x-aura::heading level="1">What you just installed</x-aura::heading>
    <x-aura::text class="mt-2 max-w-3xl">
        Every component below is running in this page, in your theme, under the MIT licence —
        nothing here is a screenshot. Change the colour scale in
        <code>resources/css/app.css</code> and all of it follows.
    </x-aura::text>

    {{-- Forms --}}
    <x-aura::heading level="2" class="mt-12">Forms</x-aura::heading>
    <x-aura::text class="mt-1">
        The date picker, the autocomplete and the file upload are free here. Most kits keep them
        for the paid tier.
    </x-aura::text>

    <x-aura::card class="mt-4">
        <div class="grid gap-6 md:grid-cols-2">
            <x-aura::input label="Email" name="demo_email" type="email" placeholder="you@example.com" />
            <x-aura::date-picker label="Start date" name="demo_date" />
            <x-aura::autocomplete
                label="Country"
                name="demo_country"
                :options="['Italy', 'Germany', 'France', 'Spain', 'Portugal']"
                placeholder="Start typing..."
            />
            <x-aura::select label="Plan" name="demo_plan" placeholder="Choose a plan">
                <x-aura::select.option value="free">Free</x-aura::select.option>
                <x-aura::select.option value="pro">Pro</x-aura::select.option>
            </x-aura::select>
            <x-aura::textarea label="Notes" name="demo_notes" placeholder="Anything worth remembering..." />
            <x-aura::file-upload label="Attachment" accept="image/*,.pdf" />
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-6">
            <x-aura::checkbox label="Send me the release notes" name="demo_news" />
            <x-aura::toggle label="Dark mode by default" name="demo_dark" />
            <x-aura::rating :value="4" />
        </div>
    </x-aura::card>

    {{-- Feedback --}}
    <x-aura::heading level="2" class="mt-12">Feedback</x-aura::heading>

    <div class="mt-4 grid gap-4">
        <x-aura::alert variant="success">Your changes have been saved.</x-aura::alert>
        <x-aura::alert variant="warning">Your licence expires in seven days.</x-aura::alert>
        <x-aura::alert variant="danger">We could not reach the payment provider.</x-aura::alert>
    </div>

    <x-aura::card class="mt-4">
        <div class="flex flex-wrap items-center gap-3">
            <x-aura::badge variant="success">Active</x-aura::badge>
            <x-aura::badge variant="warning">Pending</x-aura::badge>
            <x-aura::badge variant="danger">Failed</x-aura::badge>
            <x-aura::badge variant="info">Draft</x-aura::badge>
            <x-aura::spinner />
        </div>

        <div class="mt-6 space-y-3">
            <x-aura::progress :value="72" />
            <x-aura::skeleton class="h-4 w-64" />
        </div>
    </x-aura::card>

    {{-- Buttons --}}
    <x-aura::heading level="2" class="mt-12">Buttons</x-aura::heading>

    <x-aura::card class="mt-4">
        <div class="flex flex-wrap items-center gap-3">
            <x-aura::button variant="primary">Primary</x-aura::button>
            <x-aura::button variant="secondary">Secondary</x-aura::button>
            <x-aura::button variant="success">Success</x-aura::button>
            <x-aura::button variant="danger">Danger</x-aura::button>
            <x-aura::button variant="ghost">Ghost</x-aura::button>
            <x-aura::tooltip text="Tooltips are free too">
                <x-aura::button variant="secondary">Hover me</x-aura::button>
            </x-aura::tooltip>
        </div>
    </x-aura::card>

    {{-- Data --}}
    <x-aura::heading level="2" class="mt-12">Data</x-aura::heading>

    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-aura::stats-card title="Users" value="1,284" />
        <x-aura::stats-card title="Revenue" value="€12,480" />
        <x-aura::stats-card title="Orders" value="312" />
        <x-aura::stats-card title="Refunds" value="4" />
    </div>

    <x-aura::card class="mt-4">
        <x-aura::table striped hoverable>
            <x-aura::table.head>
                <x-aura::table.row>
                    <x-aura::table.header>Name</x-aura::table.header>
                    <x-aura::table.header>Email</x-aura::table.header>
                    <x-aura::table.header>Status</x-aura::table.header>
                </x-aura::table.row>
            </x-aura::table.head>
            <x-aura::table.body>
                @foreach ([['Alice Johnson', 'alice@example.com', 'success', 'Active'], ['Bruno Conti', 'bruno@example.com', 'warning', 'Pending'], ['Chiara Rossi', 'chiara@example.com', 'danger', 'Suspended']] as [$name, $email, $variant, $status])
                    <x-aura::table.row>
                        <x-aura::table.cell>{{ $name }}</x-aura::table.cell>
                        <x-aura::table.cell>{{ $email }}</x-aura::table.cell>
                        <x-aura::table.cell>
                            <x-aura::badge :variant="$variant">{{ $status }}</x-aura::badge>
                        </x-aura::table.cell>
                    </x-aura::table.row>
                @endforeach
            </x-aura::table.body>
        </x-aura::table>
    </x-aura::card>

    <x-aura::card class="mt-4">
        <x-aura::chart
            type="line"
            :labels="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']"
            :datasets="[[
                'label' => 'Revenue',
                'data' => [1200, 1900, 3000, 5000, 4200, 6100],
                'borderColor' => '#7c3aed',
                'backgroundColor' => 'rgba(124, 58, 237, 0.12)',
                'fill' => true,
                'tension' => 0.4,
            ]]"
        />
    </x-aura::card>

    {{-- Everything else --}}
    <x-aura::heading level="2" class="mt-12">And the rest of them</x-aura::heading>
    <x-aura::text class="mt-1 max-w-3xl">
        The list below is read from the registry inside the package you installed, so it always
        describes your version — {{ $components->count() }} components and {{ $blocks->count() }}
        blocks, none of them typed into this page. Open
        <x-aura::link href="{{ url('/aura/playground') }}">the playground</x-aura::link> to see any
        of them running here, or follow a name for its props.
    </x-aura::text>

    <x-aura::card class="mt-4">
        <div class="flex flex-wrap gap-2">
            {{-- $component is reserved inside an anonymous component: Blade binds it
                 to the component instance, so a loop variable of that name is
                 shadowed the moment it is used as an attribute. --}}
            @foreach ($components as $auraComponent)
                <x-aura::link
                    href="{{ $catalogue->docsUrl($auraComponent) }}"
                    class="rounded-lg border border-gray-200 px-2.5 py-1 text-sm no-underline transition hover:border-aura-primary-400 hover:bg-aura-primary-50 dark:border-gray-700 dark:hover:bg-gray-800"
                >{{ $catalogue->title($auraComponent) }}</x-aura::link>
            @endforeach
        </div>
    </x-aura::card>
</x-layouts.app>
