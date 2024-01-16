package main

import (
	"fmt"
	"log"
	"runtime"
	"time"

	"github.com/Fesaa/PulseWatcher/test-C2SPackerHandler/proto/packets"
	"github.com/gorilla/websocket"
	"google.golang.org/protobuf/proto"
	"google.golang.org/protobuf/types/known/timestamppb"
)

func (c *Client) Handle(done chan struct{}) {
	defer close(done)
	for {
		msgType, message, err := c.conn.ReadMessage()
		if err != nil {
			log.Println("read:", err)
			return
		}

		if msgType == websocket.CloseMessage {
			fmt.Println("Server closed connection")
			return
		}

		packet := packets.S2CPacket{}
		err = proto.Unmarshal(message, &packet)
		if err != nil {
			log.Println("unmarshal:", err)
			return
		}

		c.handlePacket(&packet)
	}
}

func (c *Client) handlePacket(packet *packets.S2CPacket) {
	switch packet.Packet.(type) {
	case *packets.S2CPacket_PingPacket:
		c.handlePingPacket(packet.GetPingPacket())
		break
	case *packets.S2CPacket_RegisterPacket:
		c.handleRegisterPacket(packet.GetRegisterPacket())
		break
	case *packets.S2CPacket_MetricPacket:
		c.handleMetricPacket(packet.GetMetricPacket())
		break
	case *packets.S2CPacket_ChangeConfigPacket:
		c.handleChangeConfigPacket(packet.GetChangeConfigPacket())
		break
	default:
		log.Println("Unknown packet type")
	}
}

func (c *Client) handleChangeConfigPacket(packet *packets.S2CChangeConfigPacket) {
	if packet.ConfigField.Name == "message" {
		returnMessage = packet.ConfigField.CurrentValue
	} else {
		log.Println("Unknown config field" + packet.ConfigField.Name)
	}
}

func (c *Client) handleMetricPacket(packet *packets.S2CMetricPacket) {
	log.Println("Metric packet received")

	m := runtime.MemStats{}
	runtime.ReadMemStats(&m)

	metric := &packets.C2SMetricPacket{
		RamUsage: int64(m.Sys),
		Uptime:   int64(time.Since(start)),
		Metrics: &packets.C2SMetricPacket_ApiClientMetric{
			ApiClientMetric: &packets.APIClientMetric{

				Os:   runtime.GOOS + " " + runtime.GOARCH,
				Host: "localhost",
				Port: "2020",

				ApiEndPointMetrics: []*packets.APIEndPointMetric{
					{
						EndPoint: "/counter",
						Hits:     int64(counter),
						Errors:   0,
					},
				},
			},
		},
	}

	res := &packets.C2SPacket{
		Token: c.token,
		Packet: &packets.C2SPacket_MetricPacket{
			MetricPacket: metric,
		},
	}

	data, err := proto.Marshal(res)
	if err != nil {
		log.Println("marshal:", err)
		return
	}

	err = c.conn.WriteMessage(websocket.BinaryMessage, data)
	if err != nil {
		log.Println("write:", err)
		return
	}
}

func (c *Client) handlePingPacket(packet *packets.S2CPingPacket) {
	log.Println("Ping packet received")

	ping := &packets.C2SPingPacket{
		Timestamp: timestamppb.New(time.Now()),
	}

	res := &packets.C2SPacket{
		Token: c.token,
		Packet: &packets.C2SPacket_PingPacket{
			PingPacket: ping,
		},
	}

	data, err := proto.Marshal(res)
	if err != nil {
		log.Println("marshal:", err)
		return
	}

	err = c.conn.WriteMessage(websocket.BinaryMessage, data)
	if err != nil {
		log.Println("write:", err)
		return
	}

}

func (c *Client) handleRegisterPacket(packet *packets.S2CRegisterPacket) {
	log.Println("Register packet received")

	c.token = packet.Token

	register := &packets.C2SRegisterPacket{
		Token:      packet.Token,
		Name:       name,
		ClientType: packets.ClientType_API_CLIENT,
		Config: &packets.C2SConfig{
			Fields: []*packets.ConfigField{
				{
					Name:  "host",
					Value: "127.0.0.1",
				},
				{
					Name:  "port",
					Value: port,
				},
			},
			MutableFields: []*packets.MutableConfigField{
				{
					Name:         "message",
					CurrentValue: returnMessage,
				},
			},
		},
	}

	res := &packets.C2SPacket{
		Packet: &packets.C2SPacket_RegisterPacket{
			RegisterPacket: register,
		},
	}

	data, err := proto.Marshal(res)
	if err != nil {
		log.Println("marshal:", err)
		return
	}

	err = c.conn.WriteMessage(websocket.BinaryMessage, data)
	if err != nil {
		log.Println("write:", err)
		return
	}
}
