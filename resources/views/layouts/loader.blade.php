<div id="loader-container"
    class="fixed z-[9999999] card top-0 left-0 right-0 bottom-0 flex items-center flex-col justify-center">
    <div class="flex justify-center items-center mb-5">
        <img src="{{ get_option('primary_data',true)['deep_logo'] }}" alt="logo" class="block h-[30px] dark:hidden" />
        <img src="{{ get_option('primary_data',true)['logo'] }}" alt="logo" class="hidden h-[30px] dark:block" />
    </div>
    <div class="w-1/6">
        <div class="bg-gray-200 dark:bg-gray-600 p-px rounded-md">
            <div id="loader" class="bg-primary-600 rounded-md h-1.5"></div>
        </div>

        <p id="loader-text" class="text-center text-sm mt-1">0%</p>
    </div>

</div>