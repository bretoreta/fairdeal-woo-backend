<script setup>
import { ref } from 'vue';
import TopCustomer from './TopCustomer.vue';
import FinancialReportItem from './FinancialReportItem.vue';

const options1 = 
    {
        series: [44, 55, 13, 43, 22],
        chartOptions: {
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                fontFamily: 'Montserrat',
                                fontWeight: '800',
                            }
                        }
                    }
                }
            },
            chart: {
              type: 'donut',
            },
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            dataLabels: {
                enabled: false,
            },          
            legend: {
                show: true,
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    }
                }
            }]
        },
    };

const options2 = 
    {
        series: [44, 55, 13, 43, 22],
        chartOptions: {
            chart: {
              type: 'pie',
            },
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            dataLabels: {
                enabled: false,
            },          
            legend: {
                show: true,
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    }
                }
            }]
        },
    }

const attrs = ref([
  {
    key: 'today',
    highlight: true,
    dates: new Date(),
  },
]);
</script>

<template>
    <div class="grid grid-cols-12 gap-4 mt-10">
        <div class="col-span-6">
            <div class="relative mt-12 intro-y sm:mt-5 before:content-[''] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70">
                <div class="bg-white rounded-md border p-6 sm:flex relative" data-aos="fade-up" data-aos-once="true">
                    <div class="flex flex-col justify-center flex-1 px-8 py-12">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-10 h-10 text-yellow-500">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-8">Financial Overview</h3>
                        </div>
                        <div class="relative text-3xl font-medium mt-6 text-gray-900">
                            <sup class="font-medium text-sm">Ksh </sup> 54,143.00 
                        </div>
                        <div class="cursor-pointer py-[3px] flex rounded-full text-white text-xs pl-2 pr-1 mt-3 mr-auto items-center font-medium bg-green-500">
                            47% 
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="stroke-1.5 w-4 h-4 ml-0.5">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                        </div>
                        <div class="mt-10 text-slate-500"> Sales earnings this month after associated author fees, &amp; before
                            taxes. 
                        </div>
                        <button
                            class="transition duration-200 border shadow-sm inline-flex items-center py-2 px-3 font-medium cursor-pointer focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus-visible:outline-none disabled:opacity-70 disabled:cursor-not-allowed text-slate-500 relative justify-start mt-12 rounded-full">
                            Download Reports 
                            <span
                                class="w-8 h-8 absolute flex justify-center items-center bg-green-500 text-white rounded-full right-0 top-0 bottom-0 my-auto ml-auto mr-0.5">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="stroke-1.5 w-4 h-4">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="flex flex-col gap-8 justify-center flex-1 px-8 py-12 border-t border-dashed sm:border-t-0 sm:border-l border-slate-200 dark:border-darkmode-300">
                        <FinancialReportItem text="Total Transactions" :number="54143" :percentage="2" number-is-currency />
                        <FinancialReportItem text="Cancelled Orders" :number="45" :percentage="0.1" positive />
                        <FinancialReportItem text="Gross Revenue" :number="72421" :percentage="9" number-is-currency positive />
                        <FinancialReportItem text="Gross Profit" :number="23045" :percentage="12" number-is-currency positive />
                        <FinancialReportItem text="New Customers" :number="67" :percentage="12" number-is-currency />
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 mt-14">
                <div class="col-span-2">
                    <div>
                        <div class="bg-white border rounded-md p-6" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                            <div>
                                <div class="border-b border-gray-200 py-3">
                                    <div class="inline-flex space-x-2">
                                        <h4 class="text-lg font-semibold text-gray-800">Best Selling Categories</h4>
                                    </div>
                                </div>
                            </div>
                            <div id="chart" class="my-4">
                                <apexchart :options="options1.chartOptions" :series="options1.series"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <div>
                        <div class="bg-white border rounded-md p-6" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
                            <div>
                                <div class="border-b border-gray-200 py-3">
                                    <div class="inline-flex space-x-2">
                                        <h4 class="text-lg font-semibold text-gray-800">Best Selling Shops</h4>
                                    </div>
                                </div>
                            </div>
                            <div id="chart" class="my-4">
                                <apexchart :options="options2.chartOptions" :series="options2.series"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-6">
            <div class="grid grid-cols-6 gap-4 sm:mt-5">
                <div class="col-span-3 bg-white rounded-md border p-5 items-center" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                    <div>
                        <div class="flex space-x-2 border-b pb-3">
                            <h4 class="text-lg font-semibold text-gray-800">Top Customers</h4>
                        </div>
                        <div class="mt-2">
                            <div class="flex flex-col space-y-2">
                                <TopCustomer />
                                <TopCustomer />
                                <TopCustomer />
                                <div class="pt-3 px-4">
                                    <p class="text-sm font-semibold text-center underline-effect">Show All</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-3 items-center bg-white rounded-md border p-5" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
                    <div>
                        <div class="flex space-x-2 border-b pb-3">
                            <h4 class="text-lg font-semibold text-gray-800">Your Calendar</h4>
                        </div>
                        <div class="mt-2">
                            <VCalendar borderless expanded title-position="left" color="green" :attributes="attrs" />
                        </div>
                    </div>
                </div>
                <div class="col-span-6 pb-10">
                    <div class="mt-5 bg-white border border-gray-200 rounded-md px-4" data-aos="fade-up" data-aos-delay="300" data-aos-once="true">
                        <div class="border-b py-6">
                            <div class="inline-flex space-x-2">
                                <h4 class="text-lg font-semibold text-gray-800">Weekly Top Products</h4>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-spacing-y-[10px] border-separate sm:mt-2">
                                <thead class="">
                                    <tr class="border-b border-gray-200">
                                        <th class="font-medium text-xs px-5 py-3 border-b-0 whitespace-nowrap">
                                             IMAGES 
                                        </th>
                                        <th class="font-medium text-xs px-5 py-3 border-b-0 whitespace-nowrap"> 
                                            PRODUCT NAME 
                                        </th>
                                        <th class="font-medium text-xs px-5 py-3 text-center border-b-0 whitespace-nowrap"> 
                                            STOCK 
                                        </th>
                                        <th class="font-medium text-xs px-5 py-3 text-center border-b-0 whitespace-nowrap"> 
                                            STATUS 
                                        </th>
                                        <th class="font-medium text-xs px-5 py-3 text-center border-b-0 whitespace-nowrap"> 
                                            ACTIONS 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="intro-x">
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md w-40 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <a href="" class="font-medium text-sm whitespace-nowrap">Samsung Galaxy S20 Ultra</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Smartphone &amp; Tablet</div>
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md text-center bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            50
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md w-40 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <div class="flex items-center justify-center text-green-500 text-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-2">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg> 
                                                Active
                                            </div>
                                        </td>
                                        <td class="px-5 first:rounded-l-md last:rounded-r-md w-56 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400">
                                            <div class="flex items-center justify-center">
                                                <a class="flex items-center mr-3 text-xs text-gray-500" href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                        <polyline points="9 11 12 14 22 4"></polyline>
                                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                    </svg> 
                                                    Edit 
                                                </a>
                                                <a class="flex items-center text-red-500 text-xs" href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                        <path d="M3 6h18"></path>
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg> 
                                                    Delete 
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="intro-x">
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md w-40 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <a href="" class="font-medium text-sm whitespace-nowrap">Samsung Galaxy S20 Ultra</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Smartphone &amp; Tablet</div>
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md text-center bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            50
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md w-40 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <div class="flex items-center justify-center text-green-500 text-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-2">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg> 
                                                Active
                                            </div>
                                        </td>
                                        <td class="px-5 first:rounded-l-md last:rounded-r-md w-56 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400">
                                            <div class="flex items-center justify-center">
                                                <a class="flex items-center mr-3 text-xs text-gray-500" href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                        <polyline points="9 11 12 14 22 4"></polyline>
                                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                    </svg> 
                                                    Edit 
                                                </a>
                                                <a class="flex items-center text-red-500 text-xs" href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                        <path d="M3 6h18"></path>
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg> 
                                                    Delete 
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- <tr class="intro-x">
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md w-40 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img class="cursor-pointer rounded-full w-full h-full border-2 border-blue-200" alt="Midone Tailwind HTML Admin Template" src="../../../../img/preview-8.473654d2.jpg">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <a href="" class="font-medium text-sm whitespace-nowrap">Samsung Galaxy S20 Ultra</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Smartphone &amp; Tablet</div>
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md text-center bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            50
                                        </td>
                                        <td class="px-5 py-3 first:rounded-l-md last:rounded-r-md w-40 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]">
                                            <div class="flex items-center justify-center text-green-500 text-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-2">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg> 
                                                Active
                                            </div>
                                        </td>
                                        <td class="px-5 first:rounded-l-md last:rounded-r-md w-56 bg-gray-100 border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400">
                                            <div class="flex items-center justify-center">
                                                <a class="flex items-center mr-3 text-xs text-gray-500" href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                        <polyline points="9 11 12 14 22 4"></polyline>
                                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                    </svg> 
                                                    Edit 
                                                </a>
                                                <a class="flex items-center text-red-500 text-xs" href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                        <path d="M3 6h18"></path>
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg> 
                                                    Delete 
                                                </a>
                                            </div>
                                        </td>
                                    </tr> -->
                                           
                                </tbody>
                            </table>
                        </div>
                        <div class="py-3 px-4">
                            <p class="text-sm font-semibold text-center underline-effect">Show All</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>