<div class="w-[300px] px-2 py-4">
    <div class="flex flex-col items-center">
        <img alt="avatar" lazy
            class="bg-white -mt-16 fi-avatar object-cover object-center !w-24 !h-24 mb-3 rounded-full shadow-xl"
            src="{{ $record->avatar ? asset("storage/{$record->avatar}") : asset("images/avatar.png") }}"
        />

        <h2 class="mb-3 text-xl font-medium text-gray-900 dark:text-white">{{ $record->name }}</h2>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $record->email }}</span>
    </div>
</div>