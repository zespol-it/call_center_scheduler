import React, { useState } from 'react';
import { Box, Container, Paper, Typography, TextField } from '@mui/material';
import { startOfWeek, endOfWeek, format } from 'date-fns';
import { useQuery } from 'react-query';
import axios from 'axios';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';

const API_URL = process.env.REACT_APP_API_URL || 'http://callcenterfront-production.up.railway.app';

const Scheduler = () => {
  const [selectedDate, setSelectedDate] = useState(new Date());
  const startDate = startOfWeek(selectedDate);
  const endDate = endOfWeek(selectedDate);

  const { data: shifts, isLoading: shiftsLoading } = useQuery(
    ['shifts', selectedDate],
    async () => {
      const response = await axios.get(`${API_URL}/api/shifts`);
      return response.data['hydra:member'];
    }
  );

  const { data: demandForecast, isLoading: forecastLoading } = useQuery(
    ['demandForecast', selectedDate],
    async () => {
      const response = await axios.get(`${API_URL}/api/demand_forecasts`);
      return response.data['hydra:member'];
    }
  );

  if (shiftsLoading || forecastLoading) {
    return <Typography>Loading...</Typography>;
  }

  return (
    <Container maxWidth="lg">
      <Box sx={{ mt: 4, mb: 4 }}>
        <Typography variant="h4" component="h1" gutterBottom>
          Call Center Scheduler
        </Typography>
        
        <Paper sx={{ p: 2, mb: 2 }}>
          <Typography variant="h6" gutterBottom>
            Select Week
          </Typography>
          <TextField
            type="date"
            value={format(selectedDate, 'yyyy-MM-dd')}
            onChange={(e) => setSelectedDate(new Date(e.target.value))}
            fullWidth
            sx={{ mb: 2 }}
          />
        </Paper>

        <Paper sx={{ p: 2, mb: 2 }}>
          <Typography variant="h6" gutterBottom>
            Shifts
          </Typography>
          <div style={{ overflowX: 'auto' }}>
            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
              <thead>
                <tr>
                  <th style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>Agent</th>
                  <th style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>Queue</th>
                  <th style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>Start Time</th>
                  <th style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>End Time</th>
                </tr>
              </thead>
              <tbody>
                {shifts?.map((shift) => (
                  <tr key={shift.id}>
                    <td style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>{shift.agent.name}</td>
                    <td style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>{shift.queue.name}</td>
                    <td style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>
                      {new Date(shift.startTime).toLocaleString()}
                    </td>
                    <td style={{ padding: '8px', borderBottom: '1px solid #ddd' }}>
                      {new Date(shift.endTime).toLocaleString()}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </Paper>

        <Paper sx={{ p: 2 }}>
          <Typography variant="h6" gutterBottom>
            Demand Forecast
          </Typography>
          <Box sx={{ height: 400 }}>
            <ResponsiveContainer width="100%" height="100%">
              <BarChart
                data={demandForecast}
                margin={{
                  top: 20,
                  right: 30,
                  left: 20,
                  bottom: 5,
                }}
              >
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis
                  dataKey="timestamp"
                  tickFormatter={(value) => new Date(value).toLocaleString()}
                />
                <YAxis />
                <Tooltip
                  labelFormatter={(value) => new Date(value).toLocaleString()}
                />
                <Legend />
                <Bar dataKey="expectedCalls" name="Expected Calls" fill="#8884d8" />
              </BarChart>
            </ResponsiveContainer>
          </Box>
        </Paper>
      </Box>
    </Container>
  );
};

export default Scheduler; 