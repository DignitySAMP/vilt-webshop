<template>
    <div class="relative min-w-96">
        <div
            class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
            :class="{ 'px-4': selectedCountry }"
            @click="toggleList"
        >
            <div v-if="selectedCountry" class="flex justify-between items-center gap-8">
                <span class="text-lg" v-html="getCountryInstance(selectedCountry).flag" />
                <span
                    class="truncate"
                    v-html="getCountryInstance(selectedCountry).name"
                />
                <span class="block size-6 text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M17.9 17.39c-.26-.8-1.01-1.39-1.9-1.39h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1V7h2a2 2 0 0 0 2-2v-.41a7.984 7.984 0 0 1 2.9 12.8M11 19.93c-3.95-.49-7-3.85-7-7.93c0-.62.08-1.22.21-1.79L9 15v1a2 2 0 0 0 2 2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2"/></svg>
                </span>
            </div>
            <div v-else class="flex justify-between text-slate-500">
                <span>No country selected</span>
                <span class="block size-6 text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M17.9 17.39c-.26-.8-1.01-1.39-1.9-1.39h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1V7h2a2 2 0 0 0 2-2v-.41a7.984 7.984 0 0 1 2.9 12.8M11 19.93c-3.95-.49-7-3.85-7-7.93c0-.62.08-1.22.21-1.79L9 15v1a2 2 0 0 0 2 2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2"/></svg>
                </span>
            </div>
        </div>

        <div
            class="bottom right absolute z-50 flex h-96 w-full flex-col gap-1 overflow-auto bg-white px-4 py-2 border border-slate-200 rounded-lg transition duration-300"
            v-if="showCountryList"
        >
            <AppFormInput
                name="filter_country"
                type="text"
                placeholder="Search country..."
                v-model="filterCountryQuery"
                @keydown="handleKeydown"
            />
            <div
                class="flex w-full cursor-pointer justify-between gap-8 px-4 py-1.5 rounded-lg hover:bg-slate-200"
                :class="{ 'bg-blue-100': index === highlightedIndex }"
                v-for="(country, index) in filteredCountryList"
                :value="country.code"
                :key="index"
                :ref="(el) => setCountryRef(el, index)"
                @click="selectCountry(country.name)"
            >
                <span v-html="country.flag" />
                <span class="truncate" v-html="country.name" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import CountryList from 'country-list-with-dial-code-and-flag';
import { computed, nextTick, ref } from 'vue';
import AppFormInput from '@/components/form/AppFormInput.vue';

const selectedCountry = defineModel<string>({ default: '' }); // model thats manipulated and sent to parent
const showCountryList = ref<boolean>(false); // toggles the list

/*
 ** filter logic: when filterCountryQuery is manipulated (the input=text), it will filter
 ** the CountryList.getAll() array to return include matches or the full list, depending on input
 */
const filterCountryQuery = ref<string>('');
const filteredCountryList = computed(() => {
    if (filterCountryQuery.value.length > 0) {
        return CountryList.getAll().filter((country) =>
            country.name
                .toLowerCase()
                .includes(filterCountryQuery.value.toLowerCase()),
        );
    }
    return CountryList.getAll();
});

/*
 ** handles keyboard inputs for intuitive browsing (arrow up/down and enter/esc)
 */
const highlightedIndex = ref<number>(0); // the current item that is indexed (used primarily with keyboard shortcuts)
const handleKeydown = (e: KeyboardEvent) => {
    const maxIndex = filteredCountryList.value.length - 1;

    switch (e.key) {
        case 'ArrowDown': {
            e.preventDefault();
            highlightedIndex.value = Math.min(
                highlightedIndex.value + 1,
                maxIndex,
            );
            scrollToHighlighted();
            break;
        }
        case 'ArrowUp': {
            e.preventDefault();
            highlightedIndex.value = Math.max(highlightedIndex.value - 1, 0);
            scrollToHighlighted();
            break;
        }
        case 'Enter': {
            e.preventDefault();
            if (filteredCountryList.value[highlightedIndex.value]) {
                selectCountry(
                    filteredCountryList.value[highlightedIndex.value].name,
                );
            }
            break;
        }
        case 'Escape': {
            showCountryList.value = false;
            filterCountryQuery.value = '';
            highlightedIndex.value = 0;
            break;
        }
        default: {
            highlightedIndex.value = 0; // reset highlight when typing
            break;
        }
    }
};

/*
 ** method that will toggle the list, and if opened, will reset the highlighted
 ** index to 0(default)
 */
const toggleList = () => {
    showCountryList.value = !showCountryList.value;
    if (showCountryList.value) {
        highlightedIndex.value = 0;
    }
};

/*
 ** method that will properly update the model and clean up UX related variables
 ** closes the list, resets filter query and resets highlight index
 */
const selectCountry = (countryName: string) => {
    selectedCountry.value = countryName;
    showCountryList.value = false;
    filterCountryQuery.value = '';
    highlightedIndex.value = 0;
};

/*
 ** in order to add auto scroll / highlighting whne using keys (up/down/enter) to browse
 ** the list, we map every country to a list which is triggered through scrollToHighlighted
 */
const countryRefs = ref<(HTMLElement | null)[]>([]);
const setCountryRef = (el: any, index: number) => {
    if (el) {
        countryRefs.value[index] = el;
    }
};

const scrollToHighlighted = () => {
    nextTick(() => {
        const highlightedElement = countryRefs.value[highlightedIndex.value];
        if (highlightedElement) {
            highlightedElement.scrollIntoView({
                block: 'nearest',
                behavior: 'smooth',
            });
        }
    });
};

/*
 ** returns the array of a country returned by a keyword: we only ever call this using the
 ** full country name, so it is safe to return index 0 since the package handles empty inputs gracefully
 */
const getCountryInstance = (keyword: string) =>
    CountryList.findByKeyword(keyword)[0];
</script>
