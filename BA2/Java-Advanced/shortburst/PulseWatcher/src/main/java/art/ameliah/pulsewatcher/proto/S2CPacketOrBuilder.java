// Generated by the protocol buffer compiler.  DO NOT EDIT!
// source: packets.proto

// Protobuf Java Version: 3.25.1
package art.ameliah.pulsewatcher.proto;

public interface S2CPacketOrBuilder extends
    // @@protoc_insertion_point(interface_extends:art.ameliah.pulsewatcher.S2CPacket)
    com.google.protobuf.MessageOrBuilder {

  /**
   * <code>.art.ameliah.pulsewatcher.S2CRegisterPacket registerPacket = 1;</code>
   * @return Whether the registerPacket field is set.
   */
  boolean hasRegisterPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CRegisterPacket registerPacket = 1;</code>
   * @return The registerPacket.
   */
  art.ameliah.pulsewatcher.proto.S2CRegisterPacket getRegisterPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CRegisterPacket registerPacket = 1;</code>
   */
  art.ameliah.pulsewatcher.proto.S2CRegisterPacketOrBuilder getRegisterPacketOrBuilder();

  /**
   * <code>.art.ameliah.pulsewatcher.S2CPingPacket pingPacket = 2;</code>
   * @return Whether the pingPacket field is set.
   */
  boolean hasPingPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CPingPacket pingPacket = 2;</code>
   * @return The pingPacket.
   */
  art.ameliah.pulsewatcher.proto.S2CPingPacket getPingPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CPingPacket pingPacket = 2;</code>
   */
  art.ameliah.pulsewatcher.proto.S2CPingPacketOrBuilder getPingPacketOrBuilder();

  /**
   * <code>.art.ameliah.pulsewatcher.S2CMetricPacket metricPacket = 3;</code>
   * @return Whether the metricPacket field is set.
   */
  boolean hasMetricPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CMetricPacket metricPacket = 3;</code>
   * @return The metricPacket.
   */
  art.ameliah.pulsewatcher.proto.S2CMetricPacket getMetricPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CMetricPacket metricPacket = 3;</code>
   */
  art.ameliah.pulsewatcher.proto.S2CMetricPacketOrBuilder getMetricPacketOrBuilder();

  /**
   * <code>.art.ameliah.pulsewatcher.S2CChangeConfigPacket changeConfigPacket = 4;</code>
   * @return Whether the changeConfigPacket field is set.
   */
  boolean hasChangeConfigPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CChangeConfigPacket changeConfigPacket = 4;</code>
   * @return The changeConfigPacket.
   */
  art.ameliah.pulsewatcher.proto.S2CChangeConfigPacket getChangeConfigPacket();
  /**
   * <code>.art.ameliah.pulsewatcher.S2CChangeConfigPacket changeConfigPacket = 4;</code>
   */
  art.ameliah.pulsewatcher.proto.S2CChangeConfigPacketOrBuilder getChangeConfigPacketOrBuilder();

  art.ameliah.pulsewatcher.proto.S2CPacket.PacketCase getPacketCase();
}
