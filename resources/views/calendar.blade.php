<x-app-layout>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    @isset($events)
        <script>
            const events = @json($events);
        </script>
    @endisset
    <script type="module">
        function isTimeRangeMoreThan24Hours(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            const timeDifferenceMs = Math.abs(end - start);
            const hoursDifference = timeDifferenceMs / (1000 * 60 * 60);

            return hoursDifference > 24;
        }

        function getColorBasedOnDate(startDate, endDate) {
            const currentDate = new Date();
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (currentDate >= start && currentDate <= end) {
                return '#06b6d4'
            } else if (currentDate < start) {
                return '#34d399';
            } else if (currentDate > end) {
                return '#ef4444';
            }
        }

        function getRandomColor() {
            const colors = ["#64748b", "#6b7280", "#71717a", "#737373", "#78716c", "#ef4444", "#f97316", "#f59e0b",
                "#eab308", "#84cc16", "#22c55e", "#10b981", "#14b8a6", "#06b6d4", "#0ea5e9", "#3b82f6", "#6366f1",
                "#8b5cf6", "#a855f7", "#d946ef", "#ec4899", "#f43f5e", "#475569", "#4b5563", "#52525b", "#525252",
                "#57534e", "#dc2626", "#ea580c", "#d97706", "#ca8a04", "#65a30d", "#16a34a", "#059669", "#0d9488",
                "#0891b2", "#0284c7", "#2563eb", "#4f46e5", "#7c3aed", "#9333ea", "#c026d3", "#db2777", "#e11d48",
                "#334155", "#374151", "#3f3f46", "#404040", "#44403c", "#b91c1c", "#c2410c", "#b45309", "#a16207",
                "#4d7c0f", "#15803d", "#047857", "#0f766e", "#0e7490", "#0369a1", "#1d4ed8", "#4338ca", "#6d28d9",
                "#7e22ce", "#a21caf", "#be185d", "#be123c", "#94a3b8", "#9ca3af", "#a1a1aa", "#a3a3a3", "#a8a29e",
                "#f87171", "#fb923c", "#fbbf24", "#facc15", "#a3e635", "#4ade80", "#34d399", "#2dd4bf", "#22d3ee",
                "#38bdf8", "#60a5fa", "#818cf8", "#a78bfa", "#c084fc", "#e879f9", "#f472b6", "#fb7185"
            ];

            const randomIndex = Math.floor(Math.random() * colors.length);
            const randomColor = colors[randomIndex];

            return randomColor;
        }
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                aspectRatio: 2.6,
                initialView: 'dayGridMonth',
                headerToolbar: {
                    right: 'today prev,next',
                    center: 'title',
                    left: 'dayGridMonth,timeGridWeek'
                },
                views: {
                    dayGridMonth: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit'
                        }
                    },
                    timeGridWeek: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit'
                        }
                    }
                },
                events: []
            });
            if (events) {
                events.forEach(event => {
                    let eventObj = {
                        title: event.title,
                        start: event.start.replace(' ', 'T'),
                        end: event.end.replace(' ', 'T'),
                        allDay: isTimeRangeMoreThan24Hours(event.start, event.end),
                        color: getRandomColor()
                    }
                    calendar.addEvent(eventObj);
                })
            }
            calendar.render();
        });
    </script>
    <div id='calendar' class="mt-24 mx-8 p-4 bg-white rounded-lg shadow-md overflow-x-scroll"></div>


</x-app-layout>
