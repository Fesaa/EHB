// Generated by the protocol buffer compiler.  DO NOT EDIT!
// source: packets.proto

// Protobuf Java Version: 3.25.1
package art.ameliah.pulsewatcher.proto;

public final class Packets {
  private Packets() {}
  public static void registerAllExtensions(
      com.google.protobuf.ExtensionRegistryLite registry) {
  }

  public static void registerAllExtensions(
      com.google.protobuf.ExtensionRegistry registry) {
    registerAllExtensions(
        (com.google.protobuf.ExtensionRegistryLite) registry);
  }
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_S2CPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_S2CPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_C2SPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_C2SPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_S2CRegisterPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_S2CRegisterPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_C2SRegisterPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_C2SRegisterPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_C2SConfig_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_C2SConfig_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_ConfigField_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_ConfigField_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_MutableConfigField_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_MutableConfigField_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_S2CChangeConfigPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_S2CChangeConfigPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_S2CPingPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_S2CPingPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_C2SPingPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_C2SPingPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_S2CMetricPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_S2CMetricPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_APIClientMetric_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_APIClientMetric_fieldAccessorTable;
  static final com.google.protobuf.Descriptors.Descriptor
    internal_static_art_ameliah_pulsewatcher_APIEndPointMetric_descriptor;
  static final 
    com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internal_static_art_ameliah_pulsewatcher_APIEndPointMetric_fieldAccessorTable;

  public static com.google.protobuf.Descriptors.FileDescriptor
      getDescriptor() {
    return descriptor;
  }
  private static  com.google.protobuf.Descriptors.FileDescriptor
      descriptor;
  static {
    java.lang.String[] descriptorData = {
      "\n\rpackets.proto\022\030art.ameliah.pulsewatche" +
      "r\032\037google/protobuf/timestamp.proto\"\255\002\n\tS" +
      "2CPacket\022E\n\016registerPacket\030\001 \001(\0132+.art.a" +
      "meliah.pulsewatcher.S2CRegisterPacketH\000\022" +
      "=\n\npingPacket\030\002 \001(\0132\'.art.ameliah.pulsew" +
      "atcher.S2CPingPacketH\000\022A\n\014metricPacket\030\003" +
      " \001(\0132).art.ameliah.pulsewatcher.S2CMetri" +
      "cPacketH\000\022M\n\022changeConfigPacket\030\004 \001(\0132/." +
      "art.ameliah.pulsewatcher.S2CChangeConfig" +
      "PacketH\000B\010\n\006packet\"\355\001\n\tC2SPacket\022\r\n\005toke" +
      "n\030\001 \001(\t\022E\n\016registerPacket\030\002 \001(\0132+.art.am" +
      "eliah.pulsewatcher.C2SRegisterPacketH\000\022=" +
      "\n\npingPacket\030\003 \001(\0132\'.art.ameliah.pulsewa" +
      "tcher.C2SPingPacketH\000\022A\n\014metricPacket\030\004 " +
      "\001(\0132).art.ameliah.pulsewatcher.C2SMetric" +
      "PacketH\000B\010\n\006packet\"\"\n\021S2CRegisterPacket\022" +
      "\r\n\005token\030\001 \001(\t\"\237\001\n\021C2SRegisterPacket\022\r\n\005" +
      "token\030\001 \001(\t\022\014\n\004name\030\002 \001(\t\0223\n\006config\030\003 \001(" +
      "\0132#.art.ameliah.pulsewatcher.C2SConfig\0228" +
      "\n\nclientType\030\004 \001(\0162$.art.ameliah.pulsewa" +
      "tcher.ClientType\"\207\001\n\tC2SConfig\0225\n\006fields" +
      "\030\001 \003(\0132%.art.ameliah.pulsewatcher.Config" +
      "Field\022C\n\rmutableFields\030\002 \003(\0132,.art.ameli" +
      "ah.pulsewatcher.MutableConfigField\"*\n\013Co" +
      "nfigField\022\014\n\004name\030\001 \001(\t\022\r\n\005value\030\002 \001(\t\"8" +
      "\n\022MutableConfigField\022\014\n\004name\030\001 \001(\t\022\024\n\014cu" +
      "rrentValue\030\002 \001(\t\"Z\n\025S2CChangeConfigPacke" +
      "t\022A\n\013configField\030\001 \001(\0132,.art.ameliah.pul" +
      "sewatcher.MutableConfigField\">\n\rS2CPingP" +
      "acket\022-\n\ttimestamp\030\001 \001(\0132\032.google.protob" +
      "uf.Timestamp\">\n\rC2SPingPacket\022-\n\ttimesta" +
      "mp\030\001 \001(\0132\032.google.protobuf.Timestamp\"\021\n\017" +
      "S2CMetricPacket\"\204\001\n\017C2SMetricPacket\022\020\n\010r" +
      "amUsage\030\001 \001(\003\022\016\n\006uptime\030\002 \001(\003\022D\n\017apiClie" +
      "ntMetric\030\003 \001(\0132).art.ameliah.pulsewatche" +
      "r.APIClientMetricH\000B\t\n\007metrics\"\202\001\n\017APICl" +
      "ientMetric\022\014\n\004host\030\001 \001(\t\022\n\n\002os\030\002 \001(\t\022\014\n\004" +
      "port\030\003 \001(\t\022G\n\022apiEndPointMetrics\030\004 \003(\0132+" +
      ".art.ameliah.pulsewatcher.APIEndPointMet" +
      "ric\"C\n\021APIEndPointMetric\022\020\n\010endPoint\030\001 \001" +
      "(\t\022\014\n\004hits\030\002 \001(\003\022\016\n\006errors\030\003 \001(\003*?\n\nClie" +
      "ntType\022\016\n\nAPI_CLIENT\020\000\022\016\n\nWEB_CLIENT\020\001\022\021" +
      "\n\rDC_BOT_CLIENT\020\002B:\n\036art.ameliah.pulsewa" +
      "tcher.protoB\007PacketsP\001Z\rproto/packetsb\006p" +
      "roto3"
    };
    descriptor = com.google.protobuf.Descriptors.FileDescriptor
      .internalBuildGeneratedFileFrom(descriptorData,
        new com.google.protobuf.Descriptors.FileDescriptor[] {
          com.google.protobuf.TimestampProto.getDescriptor(),
        });
    internal_static_art_ameliah_pulsewatcher_S2CPacket_descriptor =
      getDescriptor().getMessageTypes().get(0);
    internal_static_art_ameliah_pulsewatcher_S2CPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_S2CPacket_descriptor,
        new java.lang.String[] { "RegisterPacket", "PingPacket", "MetricPacket", "ChangeConfigPacket", "Packet", });
    internal_static_art_ameliah_pulsewatcher_C2SPacket_descriptor =
      getDescriptor().getMessageTypes().get(1);
    internal_static_art_ameliah_pulsewatcher_C2SPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_C2SPacket_descriptor,
        new java.lang.String[] { "Token", "RegisterPacket", "PingPacket", "MetricPacket", "Packet", });
    internal_static_art_ameliah_pulsewatcher_S2CRegisterPacket_descriptor =
      getDescriptor().getMessageTypes().get(2);
    internal_static_art_ameliah_pulsewatcher_S2CRegisterPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_S2CRegisterPacket_descriptor,
        new java.lang.String[] { "Token", });
    internal_static_art_ameliah_pulsewatcher_C2SRegisterPacket_descriptor =
      getDescriptor().getMessageTypes().get(3);
    internal_static_art_ameliah_pulsewatcher_C2SRegisterPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_C2SRegisterPacket_descriptor,
        new java.lang.String[] { "Token", "Name", "Config", "ClientType", });
    internal_static_art_ameliah_pulsewatcher_C2SConfig_descriptor =
      getDescriptor().getMessageTypes().get(4);
    internal_static_art_ameliah_pulsewatcher_C2SConfig_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_C2SConfig_descriptor,
        new java.lang.String[] { "Fields", "MutableFields", });
    internal_static_art_ameliah_pulsewatcher_ConfigField_descriptor =
      getDescriptor().getMessageTypes().get(5);
    internal_static_art_ameliah_pulsewatcher_ConfigField_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_ConfigField_descriptor,
        new java.lang.String[] { "Name", "Value", });
    internal_static_art_ameliah_pulsewatcher_MutableConfigField_descriptor =
      getDescriptor().getMessageTypes().get(6);
    internal_static_art_ameliah_pulsewatcher_MutableConfigField_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_MutableConfigField_descriptor,
        new java.lang.String[] { "Name", "CurrentValue", });
    internal_static_art_ameliah_pulsewatcher_S2CChangeConfigPacket_descriptor =
      getDescriptor().getMessageTypes().get(7);
    internal_static_art_ameliah_pulsewatcher_S2CChangeConfigPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_S2CChangeConfigPacket_descriptor,
        new java.lang.String[] { "ConfigField", });
    internal_static_art_ameliah_pulsewatcher_S2CPingPacket_descriptor =
      getDescriptor().getMessageTypes().get(8);
    internal_static_art_ameliah_pulsewatcher_S2CPingPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_S2CPingPacket_descriptor,
        new java.lang.String[] { "Timestamp", });
    internal_static_art_ameliah_pulsewatcher_C2SPingPacket_descriptor =
      getDescriptor().getMessageTypes().get(9);
    internal_static_art_ameliah_pulsewatcher_C2SPingPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_C2SPingPacket_descriptor,
        new java.lang.String[] { "Timestamp", });
    internal_static_art_ameliah_pulsewatcher_S2CMetricPacket_descriptor =
      getDescriptor().getMessageTypes().get(10);
    internal_static_art_ameliah_pulsewatcher_S2CMetricPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_S2CMetricPacket_descriptor,
        new java.lang.String[] { });
    internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_descriptor =
      getDescriptor().getMessageTypes().get(11);
    internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_descriptor,
        new java.lang.String[] { "RamUsage", "Uptime", "ApiClientMetric", "Metrics", });
    internal_static_art_ameliah_pulsewatcher_APIClientMetric_descriptor =
      getDescriptor().getMessageTypes().get(12);
    internal_static_art_ameliah_pulsewatcher_APIClientMetric_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_APIClientMetric_descriptor,
        new java.lang.String[] { "Host", "Os", "Port", "ApiEndPointMetrics", });
    internal_static_art_ameliah_pulsewatcher_APIEndPointMetric_descriptor =
      getDescriptor().getMessageTypes().get(13);
    internal_static_art_ameliah_pulsewatcher_APIEndPointMetric_fieldAccessorTable = new
      com.google.protobuf.GeneratedMessageV3.FieldAccessorTable(
        internal_static_art_ameliah_pulsewatcher_APIEndPointMetric_descriptor,
        new java.lang.String[] { "EndPoint", "Hits", "Errors", });
    com.google.protobuf.TimestampProto.getDescriptor();
  }

  // @@protoc_insertion_point(outer_class_scope)
}
