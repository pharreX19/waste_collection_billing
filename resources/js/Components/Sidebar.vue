<template>
    <div
        class="h-full flex grow flex-col gap-y-5 overflow-y-auto border-l border-gray-100 bg-white px-6"
    >
        <div class="flex h-16 shrink-0 items-center">
            <img
                class="h-8 w-auto"
                src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                alt="Profile picture"
            />
        </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li v-for="item in currentNavigation" :key="item.name">
                            <Link
                                v-if="!item.children"
                                v-show="item.isAdmin ? isAdmin : true"
                                :as="isUser ? 'button' : 'a'"
                                disabled="true"
                                :href="item.href"
                                :class="[
                                    item.current
                                        ? 'bg-gray-50'
                                        : 'hover:bg-gray-50',
                                    'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 w-full',
                                ]"
                            >
                                <component
                                    :is="item.icon"
                                    class="size-6 shrink-0 text-gray-400"
                                    aria-hidden="true"
                                />
                                {{ item.name }}
                            </Link>
                            <!-- <Disclosure as="div" v-else v-slot="{ open }">
                                <DisclosureButton
                                    :class="[
                                        item.current
                                            ? 'bg-gray-50'
                                            : 'hover:bg-gray-50',
                                        'flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold text-gray-700',
                                    ]"
                                >
                                    <component
                                        :is="item.icon"
                                        class="size-6 shrink-0 text-gray-400"
                                        aria-hidden="true"
                                    />
                                    {{ item.name }}
                                    <ChevronLeftIcon
                                        :class="[
                                            open
                                                ? 'rotate-90 text-gray-500'
                                                : 'text-gray-400',
                                            'ml-auto size-5 shrink-0',
                                        ]"
                                        aria-hidden="true"
                                    />
                                </DisclosureButton>
                                 <DisclosurePanel as="ul" class="mt-1 px-10">
                                    <li
                                        v-for="subItem in item.children"
                                        :key="subItem.name"
                                    >
                                        <DisclosureButton
                                            as="a"
                                            :href="subItem.href"
                                            :class="[
                                                subItem.current
                                                    ? 'bg-gray-50'
                                                    : 'hover:bg-gray-50',
                                                'block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700',
                                            ]"
                                            >{{
                                                subItem.name
                                            }}</DisclosureButton
                                        >
                                    </li>
                                </DisclosurePanel>
                            </Disclosure> -->
                        </li>
                    </ul>
                </li>
                <!-- <li class="-mx-6 mt-auto"> -->
                <!-- <a
                        href="#"
                        class="flex items-center gap-x-4 px-6 py-3 text-sm/6 font-semibold text-gray-900 hover:bg-gray-50"
                    >
                        <img
                            class="size-8 rounded-full bg-gray-50"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt=""
                        />
                        <span class="sr-only">Your profile</span>
                        <span aria-hidden="true">ޓޮމް ކުކް</span>
                    </a> -->
                <Menu as="div" class="relative shrink-0 my-auto mb-5">
                    <div>
                        <MenuButton
                            class="relative flex rounded-full bg-white text-sm ring-2 ring-white/20 focus:outline-none focus:ring-white"
                        >
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">Open user menu</span>
                            <img
                                class="size-8 rounded-full"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt=""
                            />
                        </MenuButton>
                    </div>
                    <transition
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                    >
                        <MenuItems
                            class="absolute -right-2 bottom-10 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none"
                        >
                            <MenuItem
                                v-for="item in userNavigation"
                                :key="item.name"
                                v-slot="{ active }"
                            >
                                <Link
                                    :href="item.href"
                                    :method="item.method"
                                    :class="[
                                        active
                                            ? 'bg-gray-100 outline-none'
                                            : '',
                                        'block w-full text-right px-4 py-2 text-sm text-gray-700',
                                    ]"
                                    >{{ item.name }}</Link
                                >
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
                <!-- </li> -->
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronLeftIcon } from "@heroicons/vue/20/solid";
import { Squares2X2Icon } from "@heroicons/vue/24/outline";
import { CurrencyEuroIcon } from "@heroicons/vue/24/outline";
import { ChartPieIcon, HomeIcon, WrenchIcon } from "@heroicons/vue/24/outline";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, onMounted, reactive } from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { useUserRole } from "@/composables/useUserRole";

const page = usePage();
const { isUser, isAdmin } = useUserRole();

const userNavigation = [
    { name: "ޔޫޒަރ ޕުރޮފައިލް", href: route("users.show"), method: "GET" },
    // { name: "Settings", href: "#" },
    { name: "ލޮގް އައުޓް", href: route("auth.logout"), method: "POST" },
];

const navigation = reactive([
    {
        name: "ޑޭޝްބޯޑް",
        href: route("dashboard"),
        icon: Squares2X2Icon,
        current: true,
    },
    {
        name: "ގޭބިސީ ރަޖިސްޓްރީ",
        href: route("properties.index"),
        icon: HomeIcon,
        current: false,
    },
    {
        name: "ފައިސާ ބަލައިގަތުން",
        href: route("properties.search"),
        icon: CurrencyEuroIcon,
        current: false,
    },
    {
        name: "ރިޕޯރޓް",
        href: route("payables.reports"),
        icon: ChartPieIcon,
        current: false,
    },
    {
        name: "ސެޓިންގްސް",
        href: route("settings.index", { type: "users" }),
        icon: WrenchIcon,
        current: false,
        isAdmin: true,
    },
]);

onMounted(() => {
    if (isUser.value) {
        navigation.length = 0;
        navigation.push({
            name: "ފައިސާ ދެއްކުން",
            href: route("payables.index", page.props.property_id),
            icon: CurrencyEuroIcon,
            current: true,
        });
    }
});

const isActive = (href) => {
    const currentPath = page.url;
    const url = new URL(href);

    return currentPath.split("?")[0] === url.pathname;
};

const currentNavigation = computed(() => {
    return navigation.map((item) => ({
        ...item,
        current: isActive(item.href),
    }));
});
</script>
