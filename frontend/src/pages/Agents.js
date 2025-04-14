import React from 'react';
import { Box, Container, Paper, Typography, Table, TableBody, TableCell, TableContainer, TableHead, TableRow } from '@mui/material';
import { useQuery } from 'react-query';
import axios from 'axios';

const API_URL = process.env.REACT_APP_API_URL || 'http://callcenterfront-production.up.railway.app';

const Agents = () => {
  const { data: agents, isLoading } = useQuery(
    'agents',
    async () => {
      const response = await axios.get(`${API_URL}/api/agents`);
      return response.data['hydra:member'];
    }
  );

  if (isLoading) {
    return <Typography>Loading...</Typography>;
  }

  return (
    <Container maxWidth="lg">
      <Box sx={{ mt: 4, mb: 4 }}>
        <Typography variant="h4" component="h1" gutterBottom>
          Agents
        </Typography>
        
        <Paper sx={{ p: 2 }}>
          <TableContainer>
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell>Name</TableCell>
                  <TableCell>Queues</TableCell>
                  <TableCell>Availability</TableCell>
                  <TableCell>Efficiency</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {agents?.map((agent) => (
                  <TableRow key={agent.id}>
                    <TableCell>{agent.name}</TableCell>
                    <TableCell>
                      {agent.queues?.map((queue) => queue.name).join(', ')}
                    </TableCell>
                    <TableCell>
                      {Object.entries(agent.availability || {}).map(([day, hours]) => (
                        <div key={day}>
                          {day}: {hours.join(', ')}
                        </div>
                      ))}
                    </TableCell>
                    <TableCell>
                      {Object.entries(agent.efficiency || {}).map(([skill, level]) => (
                        <div key={skill}>
                          {skill}: {level}%
                        </div>
                      ))}
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </TableContainer>
        </Paper>
      </Box>
    </Container>
  );
};

export default Agents; 