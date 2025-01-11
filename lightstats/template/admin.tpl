<section>
    <h3>{{Lang.lightstats.choose-date}}</h3>
    <form method="post" action="{{linkToHome}}">
        <p>
            <label for="dateStart">{{Lang.lightstats.begin-date}}</label>
            <input id="dateStart" name="dateStart" type="date" value="{{browserDateStart}}">
            <label for="dateEnd">{{Lang.lightstats.end-date}}</label>
            <input id="dateEnd" name="dateEnd" type="date" value="{{browserDateEnd}}">
        </p>
        <p>
            <button type="submit" class="button">{{Lang.lightstats.see-statistics}}</button>
        </p>
    </form>
</section>

{% IF logsManager.hasLogs %}
<section>
        <h3>{{Lang.lightstats.data-daily-on-period}} : {{inDateStart}} - {{inDateEnd}}</h3>
        <canvas id="graphStats"></canvas>
        <script>
            var ctx = document.getElementById('graphStats');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [{{chartDays}}],
                    datasets: [{
                            label: '{{Lang.lightstats.uniques-visitors}}',
                            data: [{{chartVisitors}}]
                        },
                        {
                            label: '{{Lang.lightstats.views-pages}}',
                            data: [{{chartPages}}]
                        }]
                }
            });
        </script>
    </section>
    <section>
        <h3>{{Lang.lightstats.data-on-period}} : {{inDateStart}} - {{inDateEnd}}</h3>
        <table id="lightStatsTable">
            <thead>
                <tr>
                    <th>{{Lang.date}}</th>
                    <th>{{Lang.lightstats.page}}</th>
                    <th>{{Lang.lightstats.referer}}</th>
                    <th>{{Lang.lightstats.browser}}</th>
                    <th>{{Lang.lightstats.os}}</th>
                    <th>{{Lang.lightstats.robot}}</th>
                    <th>{{Lang.lightstats.ip}}</th>
                </tr>
            </thead>
            <tbody>
            {% for stat in logs %}
                <tr>
                    <td>{{stat.date}}</td>
                    <td><a href="{{util.urlBuild(stat.page)}}">{{stat.page}}</a></td>
                    <td><a href="{{stat.referer}}">{{stat.referer}}</a></td>
                    <td>{{stat.browser}}</td>
                    <td>{{stat.platform}}</td>
                    <td>{% if stats.isBot %}{{Lang.lightstats.yes}}{% else %}{{Lang.lightstats.no}}{% endif %}</td></td>
                    <td>{{stat.ip}}</td>
                </tr>
            {% endfor %}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">{{Lang.lightstats.uniques-visitors-period}} : {{count(logsManager.uniquesVisitor)}}</td>
                    <td colspan="3">{{Lang.lightstats.views-pages-period}} : {{count(logs)}}</td>
                </tr>
            </tfoot>
        </table>
    </section>
{% ELSE %}
            <p>{{Lang.lightstats.no-data}}</p>
{% ENDIF %}