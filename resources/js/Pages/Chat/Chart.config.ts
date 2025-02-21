// chart.config.ts
import { ChartConfiguration } from 'chart.js';

export interface Dataset {
  label: string;
  value: number;
}

export const createRadarChartConfig = (datasets: Dataset[]): ChartConfiguration<'radar'> => {
  return {
    type: 'radar',
    data: {
      labels: datasets.map((d) => d.label),
      datasets: [
        {
          label: '評価スコア(1-5)',
          data: datasets.map((d) => d.value),
          backgroundColor: 'rgba(255, 206, 86, 0.2)',
          borderColor: 'rgba(255, 159, 64, 1)',
          borderWidth: 2,
          pointBackgroundColor: 'rgba(255, 99, 132, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(255, 99, 132, 1)',
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        r: {
          min: 1,
          max: 5,
          angleLines: { color: 'rgba(255,255,255,0.3)' },
          grid: { color: 'rgba(255,255,255,0.3)' },
          ticks: { backdropColor: 'rgba(0,0,0,0.5)' },
        },
      },
      plugins: {
        legend: {
          labels: {
            color: '#fff',
          },
        },
      },
    },
  };
};
