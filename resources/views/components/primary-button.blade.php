<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-autosocial-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-autosocial-secondary focus:bg-autosocial-secondary active:bg-autosocial-secondary focus:outline-none focus:ring-2 focus:ring-autosocial-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-md']) }}>
    {{ $slot }}
</button>
