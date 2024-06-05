<script setup>
import { CalendarDate, DateFormatter, getLocalTimeZone } from '@internationalized/date'

import { ref } from 'vue'
import { cn } from '@/lib/utils'
import { Button } from '@/Components/ui/button'
import { RangeCalendar } from '@/Components/ui/range-calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'

const df = new DateFormatter('en-US', {
    dateStyle: 'medium',
})

const calendarDate = new CalendarDate(2023, 0, 20)

const value = ref({
    start: calendarDate,
    end: calendarDate.add({ days: 20 }),
})
</script>

<template>
    <div :class="cn('grid gap-2', $attrs.class ?? '')">
        <Popover>
            <PopoverTrigger as-child>
                <Button id="date" :variant="'outline'" :class="cn(
                    'w-[300px] justify-start text-left font-normal',
                    !value && 'text-muted-foreground',
                )">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mr-2 h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>

                    <template v-if="value.start">
                        <template v-if="value.end">
                            {{ df.format(value.start.toDate(getLocalTimeZone())) }} - {{
                                df.format(value.end.toDate(getLocalTimeZone())) }}
                        </template>

                        <template v-else>
                            {{ df.format(value.start.toDate(getLocalTimeZone())) }}
                        </template>
                    </template>
                    <template v-else>
                        Pick a date
                    </template>
                </Button>
            </PopoverTrigger>
            <PopoverContent class="w-auto p-0" align="end">
                <RangeCalendar v-model="value" weekday-format="short" :number-of-months="2" initial-focus
                    :placeholder="value.start" @update:start-value="(startDate) => value.start = startDate" />
            </PopoverContent>
        </Popover>
    </div>
</template>